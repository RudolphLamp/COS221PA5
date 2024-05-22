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
            case 'GetDetails':
                $this->getDetails($data);
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


    
    function handleGetSeries($data) {
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
    
        $sql = "SELECT ";
        if ( $data['return'] === "*") {
            $sql .= "*";
        } else {
            $sql .= implode(', ', $data['return']);
        }
        $sql .= " FROM series s INNER JOIN title t ON s.Title_ID = t.Title_ID";
    
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
        $series = $result->fetch_all(MYSQLI_ASSOC);
    
        $stmt->close();
        $mysqli->close();
    
        $seriesWithImages = [];
        foreach ($series as $serie) {
            $imageUrls = $this->fetchImage($serie['Title_ID']);
            $serie['image'] = $imageUrls;
            $seriesWithImages[] = $serie;
        }
    
        $this->sendResponse(200, "Success", $seriesWithImages);
    }

    
    public function getDetails($data) {
        if (!isset($data['title_ID'])) {
            $this->sendResponse(400, "Bad Request - Title ID is required");
            return;
        }

        require_once('config.php');

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Fetch the movie details
        $stmt = $mysqli->prepare("SELECT Title_ID, Title_Name, IFNULL(Content_Rating_ID, 0) AS Content_Rating_ID, Review_Rating, Release_Date, Plot_Summary, Crew, Image, IFNULL(Language_ID, 0) AS Language_ID FROM title WHERE Title_ID = ?");
        if (!$stmt) {
            $this->sendResponse(500, "Internal Server Error - Failed to prepare SQL statement");
            return;
        }

        $stmt->bind_param("i", $data['title_ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $movieDetails = $result->fetch_assoc();

        // Fetch the language name
        $stmt = $mysqli->prepare("SELECT Language_Name FROM available_language WHERE Language_ID = ?");
        if (!$stmt) {
            $this->sendResponse(500, "Internal Server Error - Failed to prepare SQL statement");
            return;
        }

        $stmt->bind_param("i", $movieDetails['Language_ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $language = $result->fetch_assoc();
        $movieDetails['Language_ID'] = $language['Language_Name'];

        // Fetch the content rating
        $stmt = $mysqli->prepare("SELECT Rating FROM content_rating WHERE Content_Rating_ID = ?");
        if (!$stmt) {
            $this->sendResponse(500, "Internal Server Error - Failed to prepare SQL statement");
            return;
        }

        $stmt->bind_param("i", $movieDetails['Content_Rating_ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $contentRating = $result->fetch_assoc();
        $movieDetails['Content_Rating_ID'] = $contentRating['Rating'];

        $stmt->close();
        $mysqli->close();

        $this->sendResponse(200, "Success", $movieDetails);
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
        
        $sql = "SELECT ";
        if ( $data['return'] === "*") {
            $sql .= "*";
        } else {
            $sql .= implode(', ', $data['return']);
        }
        $sql .= " FROM title";
    
        
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
    
        
        $allowedColumns = ['Title_ID', 'Title_Name', 'Content_Rating_ID', 'Review_Rating', 'Release_Date', 'Plot_Summary', 'Language_ID'];
    
        
        foreach ($search as $column => $value) {
            if (!in_array($column, $allowedColumns)) {
                return false; 
            }
        }
    
    
        return true; 
    }

}


$api = API::getInstance();
$api->handleRequest();



?>
