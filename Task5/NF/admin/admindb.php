<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'adminconfig.php';
class API {
    

    public function register($firstName, $lastName, $email, $password, $dateOfBirth, $adminPrivileges) {
        global $mysqli;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['status' => 'error', 'message' => 'Invalid email']);
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            return json_encode(['status' => 'error', 'message' => 'Password must have at least 8 characters with at least one uppercase letter, one number, one special character, and one lowercase letter.']);
        }
        $stmt = $mysqli->prepare("SELECT * FROM User_Account WHERE Email_Address = ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return json_encode(['status' => 'error', 'message' => 'User already exists']);
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO User_Account (First_Name, Last_Name, Email_Address, User_Password, Date_of_Birth, Admin_Privileges) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $hashed_password, $dateOfBirth, $adminPrivileges);
        if ($stmt->execute() === false) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $userID = $mysqli->insert_id;
        $message = $adminPrivileges ? 'Admin successfully created' : 'User successfully created';
        return json_encode(['status' => 'success', 'timestamp' => round(microtime(true) * 1000), 'data' => ["User_ID" => $userID, "Email" => $email, "First_Name" => $firstName, "message" => $message]]);
    }
  
    
  
    public function searchMovieTitles($title) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT Title_ID, Title_Name FROM title WHERE Title_Name LIKE ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $title = '%' . $title . '%';
        $stmt->bind_param("s", $title);
    
        $stmt->execute();
        $result = $stmt->get_result();
        $titles = $result->fetch_all(MYSQLI_ASSOC);
    
        return json_encode(['status' => 'success', 'data' => $titles]);
    }



   
    
    public function insertMovieOrSeries($Title_Name, $Content_Rating_ID, $Review_Rating, $Release_Date, $Plot_Summary, $Image, $Language_ID, $isMovie) {
        global $mysqli;
        $stmt = $mysqli->prepare("INSERT INTO title (Title_Name, Content_Rating_ID, Review_Rating, Release_Date, Plot_Summary, Image, Language_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("sissssi", $Title_Name, $Content_Rating_ID, $Review_Rating, $Release_Date, $Plot_Summary, $Image, $Language_ID);
        $stmt->execute();
        $title_id = $mysqli->insert_id;
        if ($isMovie == 1) {
            $stmt = $mysqli->prepare("INSERT INTO movie (Title_ID, Duration) VALUES (?, ?)");
            if ($stmt === false) {
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $duration = rand(90, 127);
            $stmt->bind_param("ii", $title_id, $duration);
        } elseif ($isMovie == 0) {
            $stmt = $mysqli->prepare("INSERT INTO series (Title_ID) VALUES (?)");
            if ($stmt === false) {
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->bind_param("i", $title_id);
        }
        $stmt->execute();
        return json_encode(['status' => 'success', 'data' => $title_id]);
    }
   


    public function updateMovieOrSeries($Title_ID, $Title_Name = null, $Content_Rating_ID = null, $Review_Rating = null, $Release_Date = null, $Plot_Summary = null, $Image = null, $Language_ID = null, $isMovie = null) {
        global $mysqli;
        $stmt = $mysqli->prepare("UPDATE title SET Title_Name = IFNULL(?, Title_Name), Content_Rating_ID = IFNULL(?, Content_Rating_ID), Review_Rating = IFNULL(?, Review_Rating), Release_Date = IFNULL(?, Release_Date), Plot_Summary = IFNULL(?, Plot_Summary), Image = IFNULL(?, Image), Language_ID = IFNULL(?, Language_ID) WHERE Title_ID = ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("sisssssi", $Title_Name, $Content_Rating_ID, $Review_Rating, $Release_Date, $Plot_Summary, $Image, $Language_ID, $Title_ID);
    
        $stmt->execute();
        if ($isMovie !== null) {
            $mysqli->query("DELETE FROM movie WHERE Title_ID = $Title_ID");
            $mysqli->query("DELETE FROM series WHERE Title_ID = $Title_ID");
            if ($isMovie == 1) {
                // Prepare the SQL statement for movie table
                $stmt = $mysqli->prepare("INSERT INTO movie (Title_ID, Duration) VALUES (?, ?)");
                if ($stmt === false) {
                    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
                }
                $duration = rand(90, 127);
                $stmt->bind_param("ii", $Title_ID, $duration);
            } elseif ($isMovie == 0) {
                $stmt = $mysqli->prepare("INSERT INTO series (Title_ID) VALUES (?)");
                if ($stmt === false) {
                    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
                }
    
                // Bind the parameters
                $stmt->bind_param("i", $Title_ID);
            }
    
            $stmt->execute();
        }
    
        return json_encode(['status' => 'success', 'data' => $Title_ID]);
    }
   

  
    
    
   
    
  
    public function deleteMovieOrSeries($Title_ID = null, $Title_Name = null) {
        global $mysqli;
        // If Title_Name is provided, get the Title_ID
        if ($Title_Name !== null) {
            $stmt = $mysqli->prepare("SELECT Title_ID FROM title WHERE Title_Name = ?");
            if ($stmt === false) { die('prepare() failed: ' . htmlspecialchars($mysqli->error));  }
            $stmt->bind_param("s", $Title_Name);
            if ($stmt->execute() === false) {
                die('execute() failed: ' . htmlspecialchars($stmt->error));
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $Title_ID = $result->fetch_assoc()['Title_ID'];
            } else {
                return json_encode(['status' => 'error', 'message' => 'Title not found']);
            }
        }
        // If Title_ID is still null, return an error
        if ($Title_ID === null) {
            return json_encode(['status' => 'error', 'message' => 'Title_ID is missing']);
        }
        // Delete from related tables
        $tables = ['title_genre', 'watched', 'subtitle_for', 'stars_in', 'series', 'season', 'review', 'produced', 'movie', 'dubbed_for', 'directored_by'];
        foreach ($tables as $table) {
            $mysqli->query("DELETE FROM $table WHERE Title_ID = $Title_ID");
        }
        // Finally delete from title table
        $stmt = $mysqli->prepare("DELETE FROM title WHERE Title_ID = ?");
        $stmt->bind_param("i", $Title_ID);
        $stmt->execute();
        return json_encode(['status' => 'success', 'data' => $Title_ID]);
    }

   
    public function hashExistingPasswords() {
        global $mysqli;
    
        // Select users where User_ID is between 364 and 665
        $stmt = $mysqli->prepare("SELECT * FROM User_Account WHERE User_ID BETWEEN 999 AND 1005");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Loop through each user
        while ($user = $result->fetch_assoc()) {
            // Hash the password
            $hashed_password = password_hash($user['User_Password'], PASSWORD_DEFAULT);
    
            // Update the user's password in the database
            $stmt = $mysqli->prepare("UPDATE User_Account SET User_Password = ? WHERE User_ID = ?");
            if ($stmt === false) {
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->bind_param("si", $hashed_password, $user['User_ID']);
            if ($stmt->execute() === false) {
                die('execute() failed: ' . htmlspecialchars($stmt->error));
            }
        }
    
        return json_encode(['status' => 'success', 'message' => 'Passwords for users 364 to 665 have been hashed']);
    }

 
    public function getDetails($titleId = null, $titleName = null) {
        global $mysqli;
        $stmt = null;
        if ($titleId !== null) {
            $stmt = $mysqli->prepare("SELECT Title_ID, Title_Name, IFNULL(Content_Rating_ID, 0) AS Content_Rating_ID, Review_Rating, Release_Date, Plot_Summary, Crew, Image, IFNULL(Language_ID, 0) AS Language_ID FROM title WHERE Title_ID = ?");
            $stmt->bind_param("i", $titleId);
        } else if ($titleName !== null) {
            $stmt = $mysqli->prepare("SELECT Title_ID, Title_Name, IFNULL(Content_Rating_ID, 0) AS Content_Rating_ID, Review_Rating, Release_Date, Plot_Summary, Crew, Image, IFNULL(Language_ID, 0) AS Language_ID FROM title WHERE Title_Name = ?");
            $stmt->bind_param("s", $titleName);
        } else { return json_encode(['status' => 'error', 'message' => 'Either Title_ID or Title_Name must be provided.'], JSON_UNESCAPED_SLASHES);}
        if ($stmt === false) {die('prepare() failed: ' . htmlspecialchars($mysqli->error));}
        $stmt->execute();
        $result = $stmt->get_result();
        $movieDetails = $result->fetch_assoc();
        $stmt = $mysqli->prepare("SELECT Language_Name FROM available_language WHERE Language_ID = ?");
        if ($stmt === false) {die('prepare() failed: ' . htmlspecialchars($mysqli->error)); }
        $stmt->bind_param("i", $movieDetails['Language_ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $language = $result->fetch_assoc();
        $movieDetails['Language_ID'] = $language['Language_Name'];
        $stmt = $mysqli->prepare("SELECT Rating FROM content_rating WHERE Content_Rating_ID = ?");
        if ($stmt === false) { die('prepare() failed: ' . htmlspecialchars($mysqli->error)); }
        $stmt->bind_param("i", $movieDetails['Content_Rating_ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $contentRating = $result->fetch_assoc();
        $movieDetails['Content_Rating_ID'] = $contentRating['Rating'];
        return json_encode(['status' => 'success', 'data' => $movieDetails], JSON_UNESCAPED_SLASHES);
    }
    
    

    public function login($email, $password) {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM User_Account WHERE Email_Address = ?");
        if (!$stmt) { return json_encode(['status' => 'error', 'message' => 'Database error: ' . $mysqli->error]); }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['User_Password'])) {
                unset($user['User_Password']);
                return json_encode([
                    "status" => "success",
                    "timestamp" => round(microtime(true) * 1000),
                    "data" => [$user]
                ]);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Invalid password']);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'User does not exist']);
        }
    }
}


$api = new API();
$data = json_decode(file_get_contents('php://input'), true);
if ($data['type'] == 'Register') {
    $adminPrivileges = isset($data['Admin_Privileges']) ? $data['Admin_Privileges'] : 0;  // Use 0 as the default value
    echo $api->register($data['First_Name'], $data['Last_Name'], $data['Email_Address'], $data['User_Password'], $data['Date_of_Birth'], $adminPrivileges);
} elseif ($data['type'] == 'Login') {
    echo $api->login($data['Email_Address'], $data['User_Password']);
} elseif ($data['type'] == 'HashPasswords') {
    echo $api->hashExistingPasswords();
} elseif ($data['type'] == 'SearchTitles') {
    echo $api->searchMovieTitles($data['Title_Name']);
} elseif ($data['type'] == 'GetDetails') {
    if (isset($data['Title_ID'])) {
        echo $api->getDetails($data['Title_ID']);
    } elseif (isset($data['Title_Name'])) {
        echo $api->getDetails(null, $data['Title_Name']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Either Title_ID or Title_Name must be provided.'], JSON_UNESCAPED_SLASHES);
    }
} elseif ($data['type'] == 'InsertMovieOrSeries') {
    $keys = ['Title_Name', 'Content_Rating_ID', 'Review_Rating', 'Release_Date', 'Plot_Summary', 'Image', 'Language_ID', 'isMovie'];
    foreach ($keys as $key) {
        if (!array_key_exists($key, $data)) { die("Error: '$key' is missing from data");   }
    }
    $response = $api->insertMovieOrSeries($data['Title_Name'], $data['Content_Rating_ID'], $data['Review_Rating'], $data['Release_Date'], $data['Plot_Summary'], $data['Image'], $data['Language_ID'], $data['isMovie']);
    if ($response === false) { die("Error: insertMovieOrSeries failed");  }
    echo $response;
} elseif ($data['type'] == 'UpdateMovieOrSeries') {
    $keys = ['Title_ID'];
    foreach ($keys as $key) {
        if (!array_key_exists($key, $data)) { die("Error: '$key' is missing from data");  }
    }
    $response = $api->updateMovieOrSeries(
        $data['Title_ID'], 
        $data['Title_Name'] ?? null, 
        $data['Content_Rating_ID'] ?? null, 
        $data['Review_Rating'] ?? null, 
        $data['Release_Date'] ?? null, 
        $data['Plot_Summary'] ?? null, 
        $data['Image'] ?? null, 
        $data['Language_ID'] ?? null, 
        $data['isMovie'] ?? null
    );
    if ($response === false) {
        die("Error: updateMovieOrSeries failed");
    }
    echo $response;
} elseif ($data['type'] == 'DeleteMovieOrSeries') {
    $keys = ['Title_ID', 'Title_Name'];
    $title_id = null;
    $title_name = null;
    if (array_key_exists($keys[0], $data)) { $title_id = $data['Title_ID']; }
    if (array_key_exists($keys[1], $data)) { $title_name = $data['Title_Name']; }
    if ($title_id === null && $title_name === null) { die("Error: Both 'Title_ID' and 'Title_Name' are missing from data"); }
    $response = $api->deleteMovieOrSeries($title_id, $title_name);
    if ($response === false) { die("Error: deleteMovieOrSeries failed");  }
    echo $response;
}


?>
