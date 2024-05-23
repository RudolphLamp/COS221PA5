<?php

class API {
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new API();
        }
        return self::$instance;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->sendResponse(405, "Method Not Allowed - Only POST method is allowed");
            return;
        }


        $json = file_get_contents('php://input');
        $data = json_decode($json, true);



       
        if (!isset($data['type'])) {
            $this->sendResponse(400, "Bad Request - 'type' field is required");
            return;
        }

        
        switch ($data['type']) {
            case 'Register':
                $this->handleRegistration($data);
                break;
            case 'GetMovies':
                $this->handleGetMovies($data);
                break;
            case 'GetSeries':
                $this->handleGetSeries($data);
                break;

            case 'Login':
                $this->handleLogin($data);
                break;
            
            case 'SavePreferences':
                $this->handleSavePreferences($data);
                break;

            case 'LoadPreferences': 
                $this->handleLoadPreferences($data);
                break;
            case 'AddToFavorites':
                $this->handleAddToFavorites($data);
                break;

            case 'GetAllFavouriteListings':
                $this->handleGetAllFavoriteListings($data);
                break;

            case'RemoveFromFavorites':
                $this->handleRemoveFromFavorites($data) ;
                break;

            case 'CreateAuction':
                $this->handleCreateAuction($data);
                break;

            case 'GetAllAuctions':
                $this->handleGetAuctions($data);
                break;
    
            case 'UpdateAuction':
                $this->handleUpdateAuction($data);
                break;
    
            case 'GetAuction':
                $this->handleGetAuction($data);
                break;
            case 'GetAllActiveAuctions':
                $this->handleGetAllActiveAuctions($data);
                break;
            case 'GetAllAuctions':
                $this->handleGetAllAuctions($data);
                break;
            case 'getAuctionListings':
                $this->handleGetAuctionListings($data);
                break;
            case 'getRecommendations':              /*#I've added this one*/
                $this->handleGetRecommendations($data);
                break;
            default:
                $this->sendResponse(400, "Bad Request - Invalid 'type' field");
                break;
        }
    }

    private function sendResponse($status, $message, $data = []) {
        http_response_code($status);
        echo json_encode(['status' => $message, 'timestamp' => time(), 'data' => $data]);
    }

    private function validateRequestBody($data) {
        return isset($data['type']) && isset($data['name']) && isset($data['surname']) && isset($data['email']) && isset($data['password']) && isset($data['DOB']);
    }

    private function handleRegistration($data) {
        if (!$this->validateRequestBody($data)) {
            $this->sendResponse(400, "Bad Request - Invalid JSON POST body");
            return;
        }

        if (empty($data)) {
            $this->sendResponse(400 ,"Post parameters are missing");
            return;
        }

        $validationErrors = $this->validateUserData($data);
        if (!empty($validationErrors)) {
            
            $this->sendResponse(400, "Bad Request", ["errors" => $validationErrors]);
            return;
        }

        
        if ($this->userExists($data['email'])) {
            $this->sendResponse(409, "Conflict - User already exists");
            return;
        }

        
        
        $success = $this->insertUser($data);

        
        if ($success) {
            
            $this->sendResponse(200, "Success");
        } else {
            
            $this->sendResponse(500, "Internal Server Error - Failed to insert user into database");
        }
    }

    private function validateUserData($data) {
        $errors = [];
    
        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $nameRegex = '/^[a-zA-Z\s]+$/';
        
    
        if (!preg_match($emailRegex, $data['email'])) {
            $errors[] = "Invalid email address";
        }
    
        if (!preg_match($passwordRegex, $data['password'])) {
            $errors[] = "Password must contain at least one lowercase letter, one uppercase letter, one digit, one special character, and be at least 8 characters long";
        }
    
        if (!preg_match($nameRegex, $data['name'])) {
            $errors[] = "Invalid name";
        }
    
        if (!preg_match($nameRegex, $data['surname'])) {
            $errors[] = "Invalid surname";
        }
    
        return $errors;
    }

    private function userExists($email) {
        require_once('config.php');
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
    
        
        $stmtEmail = $mysqli->prepare("SELECT * FROM user_account WHERE Email_Address = ?");
        $stmtEmail->bind_param("s", $email);
        $stmtEmail->execute();
        $resultEmail = $stmtEmail->get_result();
        $stmtEmail->close();
    
    
        $mysqli->close();
    
        
        return ($resultEmail->num_rows > 0 );
    }

    
    private function insertUser($data) {
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $admin = 0 ;
        require_once('config.php');
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $stmt = $mysqli->prepare("INSERT INTO user_account (First_Name, Last_Name, Email_Address, user_password, Date_of_Birth, Admin_privileges) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $data['name'], $data['surname'], $data['email'], $hashedPassword, $data['DOB'], $admin);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();

        return $success;
    }

    private function handleLogin($data) {
        if (!isset($data['email']) || !isset($data['password'])) {
            $this->sendResponse(400, "Bad Request - Email and password are required");
            return;
        }
        require_once('config.php');
    
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $stmt = $mysqli->prepare("SELECT User_ID, user_password FROM user_account WHERE Email_Address = ?");
        $stmt->bind_param("s", $data['email']);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows !== 1) {
            $this->sendResponse(401, "Unauthorized access - Incorrect email or password");
            return;
        }
    
        $row = $result->fetch_assoc();
        if (!password_verify($data['password'], $row['user_password']) && $data['password'] !== $row['user_password']) {
            $this->sendResponse(401, "Unauthorized access - Incorrect email / password");
            return;

        }
        
    

        $user_id = $row['User_ID'];
        setcookie("user_id", $user_id, time() + (86400 * 30), "/");
    
        $stmt->close();
        $mysqli->close();
    
        $this->sendResponse(200, "Success" , $user_id );
    }


    public function getDetails($data) {
        if (!isset($data['title_ID']) ) {
            $this->sendResponse(400, "Bad Request - Email and password are required");
            return;
        }
        require_once('config.php');
    
        // Prepare the SQL statement
        
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $stmt = $mysqli->prepare("SELECT Title_ID, Title_Name, IFNULL(Content_Rating_ID, 0) AS Content_Rating_ID, Review_Rating, Release_Date, Plot_Summary, Crew, Image, IFNULL(Language_ID, 0) AS Language_ID FROM title WHERE Title_ID = ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
    
        // Bind the titleId parameter
        $stmt->bind_param("i", $titleId);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch the movie details
        $movieDetails = $result->fetch_assoc();
    
        // Get the language name
        $stmt = $mysqli->prepare("SELECT Language_Name FROM available_language WHERE Language_ID = ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
    
        // Bind the languageId parameter
        $stmt->bind_param("i", $movieDetails['Language_ID']);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch the language name
        $language = $result->fetch_assoc();
    
        // Replace the Language_ID with the Language_Name in the movie details
        $movieDetails['Language_ID'] = $language['Language_Name'];
    
        // Get the content rating
        $stmt = $mysqli->prepare("SELECT Rating FROM content_rating WHERE Content_Rating_ID = ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
    
        // Bind the contentRatingId parameter
        $stmt->bind_param("i", $movieDetails['Content_Rating_ID']);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch the content rating
        $contentRating = $result->fetch_assoc();
    
        // Replace the Content_Rating_ID with the Rating in the movie details
        $movieDetails['Content_Rating_ID'] = $contentRating['Rating'];

        $stmt->close();
        $mysqli->close();
    
        $this->sendResponse(200, "Success" , $movieDetails );
    }


    private function handleGetMovies($data) {

        if (empty($data)) {
            $this->sendResponse(400 ,"Post parameters are missing");
            return;
        }
        
    

        
        if (!$this->validateLimit($data['limit'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'limit' parameter");
            return;
        }

        if (!$this->validateSort($data['sort'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'sort' parameter");
            return;
        }

        if (!$this->validateOrder($data['order'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'order' parameter");
            return;
        }

      

        if (!$this->validateFuzzy($data['fuzzy'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'fuzzy' parameter");
            return;
        }

        if (!$this->validateSearch($data['search'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'search' parameter");
            return;
        }

        if ( !isset($data['return'])) {
            $this->sendResponse(400, "Bad Request - Missing required parameters");
            return;
        }
        
        $sql = "
        SELECT 
            m.*, t.*, GROUP_CONCAT(DISTINCT g.Genre_Name) AS Genres, l.*
        FROM 
            title t 
            INNER JOIN movie m ON t.Title_ID = m.Title_ID
            INNER JOIN title_genre tg ON t.Title_ID = tg.Title_ID
            INNER JOIN genre g ON tg.Genre_ID = g.Genre_ID
            INNER JOIN available_language l ON t.Language_ID = l.Language_ID

        ";
        
        if (isset($data['search']) && !empty($data['search']) && $data['fuzzy'] == false) {
            $sql .= " WHERE ";
            $searchConditions = [];
            foreach ($data['search'] as $column => $value) {
                $searchConditions[] = "$column = '$value'";
            }
            $sql .= implode(" AND ", $searchConditions);
        }
    
        if (isset($data['search']) && !empty($data['search']) && $data['fuzzy'] == true) {
            $sql .= " WHERE ";
            $searchConditions = [];
            foreach ($data['search'] as $column => $value) {
                $searchConditions[] = "$column LIKE '%$value%'";
            }
            $sql .= implode(" AND ", $searchConditions);
        }

        $sql .= " GROUP BY t.Title_ID ";
    
        if (isset($data['sort']) && !isset($data['order'])) {
            if(is_array($data['sort'])){
                $ordbydata = implode(', ', $data['sort']);
            }else{
                $ordbydata = $data['sort'];
            }
            
            $sql .= " ORDER BY $ordbydata ";
        }
        
        if (isset($data['sort']) && isset($data['order'])) {
            if(is_array($data['sort'])){
                $ordbydata = implode(', ', $data['sort']);
            }else{
                $ordbydata = $data['sort'];
            }
            $sql .= " ORDER BY $ordbydata {$data['order']}";
        }

        
    
        
        if (isset($data['limit'])) {
            $sql .= " LIMIT ?";
        }
    
        
        require_once('config.php');
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $stmt = $mysqli->prepare($sql);
    
        if (!$stmt) {
            $this->sendResponse(500, "Internal Server Error - Failed to prepare SQL statement $sql");
            return;
        }
    
        

        if (isset($data['limit'])) {
            $stmt->bind_param("i", $data['limit']);
        }
    
        
        $stmt->execute();
    
        
        $result = $stmt->get_result();
        $Movies = $result->fetch_all(MYSQLI_ASSOC);
    
        
        $stmt->close();
        $mysqli->close();
    
        $MoviesWithImages = [];
    foreach ($Movies as $Movie) {
        $imageUrls = $this->fetchImage($Movie['Title_ID']);
        $Movie['image'] = $imageUrls;
        $MoviesWithImages[] = $Movie;
    }
    
        

        
        $this->sendResponse(200, "Success", $MoviesWithImages);
    }

    private function handleGetSeries($data) {

        if (empty($data)) {
            $this->sendResponse(400 ,"Post parameters are missing");
            return;
        }
        
    

        
        if (!$this->validateLimit($data['limit'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'limit' parameter");
            return;
        }

        if (!$this->validateSort($data['sort'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'sort' parameter");
            return;
        }

        if (!$this->validateOrder($data['order'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'order' parameter");
            return;
        }

      

        if (!$this->validateFuzzy($data['fuzzy'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'fuzzy' parameter");
            return;
        }

        if (!$this->validateSearch($data['search'])) {
            $this->sendResponse(400, "Bad Request - Invalid 'search' parameter");
            return;
        }

        if ( !isset($data['return'])) {
            $this->sendResponse(400, "Bad Request - Missing required parameters");
            return;
        }
        
        $sql = "
        SELECT 
            s.*, t.*, GROUP_CONCAT(DISTINCT g.Genre_Name) AS Genres, l.*
        FROM 
            title t 
            INNER JOIN series s ON t.Title_ID = s.Title_ID
            INNER JOIN title_genre tg ON t.Title_ID = tg.Title_ID
            INNER JOIN genre g ON tg.Genre_ID = g.Genre_ID
            INNER JOIN available_language l ON t.Language_ID = l.Language_ID

        ";
        
        if (isset($data['search']) && !empty($data['search']) && $data['fuzzy'] == false) {
            $sql .= " WHERE ";
            $searchConditions = [];
            foreach ($data['search'] as $column => $value) {
                $searchConditions[] = "$column = '$value'";
            }
            $sql .= implode(" AND ", $searchConditions);
        }
    
        if (isset($data['search']) && !empty($data['search']) && $data['fuzzy'] == true) {
            $sql .= " WHERE ";
            $searchConditions = [];
            foreach ($data['search'] as $column => $value) {
                $searchConditions[] = "$column LIKE '%$value%'";
            }
            $sql .= implode(" AND ", $searchConditions);
        }

        $sql .= " GROUP BY t.Title_ID ";
    
        if (isset($data['sort']) && !isset($data['order'])) {
            if(is_array($data['sort'])){
                $ordbydata = implode(', ', $data['sort']);
            }else{
                $ordbydata = $data['sort'];
            }
            
            $sql .= " ORDER BY $ordbydata ";
        }
        
        if (isset($data['sort']) && isset($data['order'])) {
            if(is_array($data['sort'])){
                $ordbydata = implode(', ', $data['sort']);
            }else{
                $ordbydata = $data['sort'];
            }
            $sql .= " ORDER BY $ordbydata {$data['order']}";
        }

        
    
        
        if (isset($data['limit'])) {
            $sql .= " LIMIT ?";
        }
    
        
        require_once('config.php');
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $stmt = $mysqli->prepare($sql);
    
        if (!$stmt) {
            $this->sendResponse(500, "Internal Server Error - Failed to prepare SQL statement $sql");
            return;
        }
    
        

        if (isset($data['limit'])) {
            $stmt->bind_param("i", $data['limit']);
        }
    
        
        $stmt->execute();
    
        
        $result = $stmt->get_result();
        $Series = $result->fetch_all(MYSQLI_ASSOC);
    
        
        $stmt->close();
        $mysqli->close();
    
        $SeriesWithImages = [];
    foreach ($Series as $Serie) {
        $imageUrls = $this->fetchImage($Serie['Title_ID']);
        $Serie['image'] = $imageUrls;
        $SeriesWithImages[] = $Serie;
    }
    
        

        
        $this->sendResponse(200, "Success", $SeriesWithImages);
    }
    
    private function fetchImage($titleid) {
        require_once('config.php');
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $stmt = $mysqli->prepare("SELECT Image FROM title WHERE Title_ID = ?");
        $stmt->bind_param("i", $titleid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows !== 1) {
            $this->sendResponse(401, "Unauthorized access - Incorrect email or password");
            return;
        }
    
        $row = $result->fetch_assoc();
        
        $imageUrl = $row['Image'];
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $imageUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false, 
            CURLOPT_SSL_VERIFYHOST => false, 
        ]);
    
        $response = curl_exec($curl);
    
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            
        }
    
        
        curl_close($curl);
    
        
        $imageUrls = json_decode($response, true);
    
        
        return $imageUrls;
    }


    private function validateLimit($limit) {
        
        return !isset($limit) || is_numeric($limit) && $limit > 0 && $limit < 500;
    }
    
    private function validateSort($sort) {
        
        $allowedSortOptions = ['Title_ID', 'Title_Name', 'Content_Rating_ID', 'Review_Rating', 'Release_Date', 'Plot_Summary', 'Language_ID'];
    
        return !isset($limit) || in_array($sort, $allowedSortOptions);
    }
    
    private function validateOrder($order) {
        
        return !isset($limit) || in_array($order, ['ASC', 'DESC']);
    }
    
    private function validateFuzzy($fuzzy) {
        return !isset($limit) || is_bool($fuzzy);
    }
    
    private function validateSearch($search) {

        
        if ($search === null) {
            return true; 
        }
    
        
        $allowedColumns = ['Title_ID', 'Title_Name', 'Content_Rating_ID', 'Review_Rating', 'Release_Date', 'Plot_Summary', 'Language_ID', 'Genre_ID', 'Genre_Name','Language_Name','Language_ID'];
    
        
        foreach ($search as $column => $value) {
            if (!in_array($column, $allowedColumns)) {
                return false; 
            }
        }
    
    
        return true; 
    }

    /*********************************************************************************************
     #get Series or Movies Recommendations
    **********************************************************************************************/ 
    
    private function handleGetRecommendations($data) {
        // Check if required parameters are provided
        if (empty($data)) {
            echo json_encode([
                "status" => 400,
                "timestamp" => time(),
                "message" => "Post parameters are missing"
            ]);
            return;
        }

        //validate the profileID parameter
        if (!isset($data["profileID"]) || !is_numeric($data["profileID"])) {
            echo json_encode([
                "status" => 400,
                "timestamp" => time(),
                "message" => "Bad Request - Invalid or missing 'profileID' parameter"
            ]);
            return;
        }

        //Validates the limit parameter
        if (!$this->validateLimit($data['limit'])) {
            echo json_encode([
                "status" => 400,
                "timestamp" => time(),
                "message" => "Bad Request - Invalid 'limit' parameter"
            ]);
            return;
        }

        //the return parameter tells us that this returns movie recommendations
        if ($data["return"] === "movies") {
            $sql = "
                SELECT t.*
                FROM title t
                JOIN title_genre tg ON t.Title_ID = tg.Title_ID
                JOIN available_language al ON t.Language_ID = al.Language_ID
                LEFT JOIN (
                    SELECT tg.Title_ID
                    FROM watched w
                    JOIN title_genre tg ON w.Title_ID = tg.Title_ID
                    WHERE w.Profile_ID = ?
                ) AS watched_titles ON t.Title_ID = watched_titles.Title_ID
                WHERE t.Language_ID = (
                        SELECT Language_ID
                        FROM title
                        JOIN watched ON watched.Title_ID = title.Title_ID
                        WHERE watched.Profile_ID = ?
                        LIMIT 1
                    )
                AND tg.Genre_ID IN (
                        SELECT Genre_ID
                        FROM title_genre
                        WHERE Title_ID IN (
                            SELECT Title_ID
                            FROM watched
                            WHERE Profile_ID = ?
                        )
                    )
                AND watched_titles.Title_ID IS NULL
                AND t.Title_ID IN (
                    SELECT Title_ID
                    FROM movie
                )
                LIMIT ?;
            ";

            require_once('config.php');
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $stmt = $mysqli->prepare($sql);     //prepare statement
            if (!$stmt) {
                echo json_encode([
                    "status" => 500,
                    "timestamp" => time(),
                    "message" => "Internal Server Error - Failed to prepare SQL statement"
                ]);
                return;
            }

            // Bind parameters and execute the query
            $profileID = $data["profileID"];
            $limit = isset($data['limit']) ? $data['limit'] : 5;
            $stmt->bind_param("iiii", $profileID, $profileID, $profileID, $limit);
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();
            $movies = $result->fetch_all(MYSQLI_ASSOC);

            // Close statement and database connection
            $stmt->close();
            $mysqli->close();

            // Fetch images for movies
            $moviesWithImages = [];
            foreach ($movies as $movie) {
                $imageUrls = $this->fetchImage($movie['Title_ID']);
                $movie['image'] = $imageUrls;
                $moviesWithImages[] = $movie;
            }

            // Send the response
            echo json_encode([
                "status" => 200,
                "timestamp" => time(),
                "message" => "Success",
                "recommendations" => $moviesWithImages
            ]);
            return;
        }

        //the return parameter tells us that this returns series recommendations
        if ($data["return"] === "series") {
            // Prepare the SQL query
            $sql = "
                SELECT t.*
                FROM title t
                JOIN title_genre tg ON t.Title_ID = tg.Title_ID
                JOIN available_language al ON t.Language_ID = al.Language_ID
                LEFT JOIN (
                    SELECT tg.Title_ID
                    FROM watched w
                    JOIN title_genre tg ON w.Title_ID = tg.Title_ID
                    WHERE w.Profile_ID = ?
                ) AS watched_titles ON t.Title_ID = watched_titles.Title_ID
                WHERE t.Language_ID = (
                        SELECT Language_ID
                        FROM title
                        JOIN watched ON watched.Title_ID = title.Title_ID
                        WHERE watched.Profile_ID = ?
                        LIMIT 1
                    )
                AND tg.Genre_ID IN (
                        SELECT Genre_ID
                        FROM title_genre
                        WHERE Title_ID IN (
                            SELECT Title_ID
                            FROM watched
                            WHERE Profile_ID = ?
                        )
                    )
                AND watched_titles.Title_ID IS NULL
                AND t.Title_ID IN (
                    SELECT Title_ID
                    FROM series
                )
                LIMIT ?;
            ";

            require_once('config.php');
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                echo json_encode([
                    "status" => 500,
                    "timestamp" => time(),
                    "message" => "Internal Server Error - Failed to prepare SQL statement"
                ]);
                return;
            }

            // Bind parameters and execute the query
            $profileID = $data["profileID"];
            $limit = isset($data['limit']) ? $data['limit'] : 5;
            $stmt->bind_param("iiii", $profileID, $profileID, $profileID, $limit);
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();
            $recommendations = $result->fetch_all(MYSQLI_ASSOC);

            // Close statement and database connection
            $stmt->close();
            $mysqli->close();

            // Fetch images for recommendations
            $recommendationsWithImages = [];
            foreach ($recommendations as $recommendation) {
                $imageUrls = $this->fetchImage($recommendation['Title_ID']);
                $recommendation['image'] = $imageUrls;
                $recommendationsWithImages[] = $recommendation;
            }

            // Send the response
            echo json_encode([
                "status" => 200,
                "timestamp" => time(),
                "message" => "Success",
                "recommendations" => $recommendationsWithImages
            ]);
            return;
        }
    }
}

$api = API::getInstance();
$api->handleRequest();

/*
_____________________
TEST RECOMMENDATIONS
____________________
POST |https://wheatley.cs.up.ac.za/PATH TO THE API

{
    "type": "getRecommendations",
    "profileID": 1,
    "limit": 5,
    "return":"series"
}

*/





?>
