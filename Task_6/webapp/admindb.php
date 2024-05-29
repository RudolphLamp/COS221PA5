<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'adminconfig.php';

class API {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    private function jsonResponse($status, $message, $data = null) {
        return json_encode(['status' => $status, 'message' => $message, 'data' => $data], JSON_UNESCAPED_SLASHES);
    }

    public function register($firstName, $lastName, $email, $password, $dateOfBirth, $adminPrivileges) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->jsonResponse('error', 'Invalid email');
        }

        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            return $this->jsonResponse('error', 'Password must have at least 8 characters with at least one uppercase letter, one number, one special character, and one lowercase letter.');
        }

        $stmt = $this->mysqli->prepare("SELECT * FROM User_Account WHERE Email_Address = ?");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $this->jsonResponse('error', 'User already exists');
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->mysqli->prepare("INSERT INTO User_Account (First_Name, Last_Name, Email_Address, User_Password, Date_of_Birth, Admin_Privileges) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $hashed_password, $dateOfBirth, $adminPrivileges);
        if ($stmt->execute() === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($stmt->error));
        }

        $userID = $this->mysqli->insert_id;
        $message = $adminPrivileges ? 'Admin successfully created' : 'User successfully created';
        return $this->jsonResponse('success', $message, ["User_ID" => $userID, "Email" => $email, "First_Name" => $firstName]);
    }

    public function searchMovieTitles($title) {
        $stmt = $this->mysqli->prepare("SELECT Title_ID, Title_Name FROM title WHERE Title_Name LIKE ?");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $title = '%' . $title . '%';
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
        $titles = $result->fetch_all(MYSQLI_ASSOC);

        return $this->jsonResponse('success', 'Titles found', $titles);
    }

    public function insertMovieOrSeries($Title_Name, $Content_Rating_ID, $Review_Rating, $Release_Date, $Plot_Summary, $Image, $Language_ID, $isMovie) {
        $stmt = $this->mysqli->prepare("INSERT INTO title (Title_Name, Content_Rating_ID, Review_Rating, Release_Date, Plot_Summary, Image, Language_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->bind_param("sissssi", $Title_Name, $Content_Rating_ID, $Review_Rating, $Release_Date, $Plot_Summary, $Image, $Language_ID);
        $stmt->execute();
        $title_id = $this->mysqli->insert_id;

        if ($isMovie == 1) {
            $stmt = $this->mysqli->prepare("INSERT INTO movie (Title_ID, Duration) VALUES (?, ?)");
            if ($stmt === false) {
                return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
            }
            $duration = rand(90, 127);
            $stmt->bind_param("ii", $title_id, $duration);
        } else {
            $stmt = $this->mysqli->prepare("INSERT INTO series (Title_ID) VALUES (?)");
            if ($stmt === false) {
                return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
            }
            $stmt->bind_param("i", $title_id);
        }

        $stmt->execute();
        return $this->jsonResponse('success', 'Movie or series inserted successfully', $title_id);
    }

    public function updateMovieOrSeries($Title_ID, $Title_Name = null, $Content_Rating_ID = null, $Review_Rating = null, $Release_Date = null, $Plot_Summary = null, $Image = null, $Language_ID = null, $isMovie = null) {
        $stmt = $this->mysqli->prepare("UPDATE title SET Title_Name = IFNULL(?, Title_Name), Content_Rating_ID = IFNULL(?, Content_Rating_ID), Review_Rating = IFNULL(?, Review_Rating), Release_Date = IFNULL(?, Release_Date), Plot_Summary = IFNULL(?, Plot_Summary), Image = IFNULL(?, Image), Language_ID = IFNULL(?, Language_ID) WHERE Title_ID = ?");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->bind_param("sisssssi", $Title_Name, $Content_Rating_ID, $Review_Rating, $Release_Date, $Plot_Summary, $Image, $Language_ID, $Title_ID);
        $stmt->execute();

        if ($isMovie !== null) {
            $this->mysqli->query("DELETE FROM movie WHERE Title_ID = $Title_ID");
            $this->mysqli->query("DELETE FROM series WHERE Title_ID = $Title_ID");

            if ($isMovie == 1) {
                $stmt = $this->mysqli->prepare("INSERT INTO movie (Title_ID, Duration) VALUES (?, ?)");
                if ($stmt === false) {
                    return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
                }
                $duration = rand(90, 127);
                $stmt->bind_param("ii", $Title_ID, $duration);
            } else {
                $stmt = $this->mysqli->prepare("INSERT INTO series (Title_ID) VALUES (?)");
                if ($stmt === false) {
                    return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
                }
                $stmt->bind_param("i", $Title_ID);
            }

            $stmt->execute();
        }

        return $this->jsonResponse('success', 'Movie or series updated successfully', $Title_ID);
    }

    public function deleteMovieOrSeries($Title_ID = null, $Title_Name = null) {
        if ($Title_Name !== null) {
            $stmt = $this->mysqli->prepare("SELECT Title_ID FROM title WHERE Title_Name = ?");
            if ($stmt === false) {
                return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
            }

            $stmt->bind_param("s", $Title_Name);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $Title_ID = $result->fetch_assoc()['Title_ID'];
            } else {
                return $this->jsonResponse('error', 'Title not found');
            }
        }

        if ($Title_ID === null) {
            return $this->jsonResponse('error', 'Title_ID is missing');
        }

        $tables = ['title_genre', 'watched', 'subtitle_for', 'stars_in', 'series', 'season', 'review', 'produced', 'movie', 'dubbed_for', 'directored_by'];
        foreach ($tables as $table) {
            $this->mysqli->query("DELETE FROM $table WHERE Title_ID = $Title_ID");
        }

        $stmt = $this->mysqli->prepare("DELETE FROM title WHERE Title_ID = ?");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->bind_param("i", $Title_ID);
        $stmt->execute();
        return $this->jsonResponse('success', 'Movie or series deleted successfully', $Title_ID);
    }

    public function hashExistingPasswords() {
        $stmt = $this->mysqli->prepare("SELECT User_ID, User_Password FROM User_Account WHERE User_Password NOT LIKE '$2y$%' AND CHAR_LENGTH(User_Password) BETWEEN 1 AND 400");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $User_ID = $row['User_ID'];
            $hashed_password = password_hash($row['User_Password'], PASSWORD_DEFAULT);
            $update_stmt = $this->mysqli->prepare("UPDATE User_Account SET User_Password = ? WHERE User_ID = ?");
            $update_stmt->bind_param("si", $hashed_password, $User_ID);
            $update_stmt->execute();
        }

        return $this->jsonResponse('success', 'Passwords hashed successfully');
    }

    public function getDetails($Title_ID = null, $Title_Name = null) {
        if ($Title_ID === null && $Title_Name === null) {
            return $this->jsonResponse('error', 'Title_ID or Title_Name is required');
        }

        if ($Title_Name !== null) {
            $stmt = $this->mysqli->prepare("SELECT Title_ID FROM title WHERE Title_Name = ?");
            if ($stmt === false) {
                return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
            }

            $stmt->bind_param("s", $Title_Name);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $Title_ID = $result->fetch_assoc()['Title_ID'];
            } else {
                return $this->jsonResponse('error', 'Title not found');
            }
        }

        $stmt = $this->mysqli->prepare("SELECT * FROM title WHERE Title_ID = ?");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->bind_param("i", $Title_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $title = $result->fetch_assoc();

        $stmt = $this->mysqli->prepare("SELECT * FROM movie WHERE Title_ID = ?");
        $stmt->bind_param("i", $Title_ID);
        $stmt->execute();
        $movie = $stmt->get_result()->fetch_assoc();

        $stmt = $this->mysqli->prepare("SELECT * FROM series WHERE Title_ID = ?");
        $stmt->bind_param("i", $Title_ID);
        $stmt->execute();
        $series = $stmt->get_result()->fetch_assoc();

        return $this->jsonResponse('success', 'Title details found', ['title' => $title, 'movie' => $movie, 'series' => $series]);
    }

    public function login($email, $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->jsonResponse('error', 'Invalid email');
        }

        $stmt = $this->mysqli->prepare("SELECT * FROM User_Account WHERE Email_Address = ?");
        if ($stmt === false) {
            return $this->jsonResponse('error', 'Database error: ' . htmlspecialchars($this->mysqli->error));
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return $this->jsonResponse('error', 'User not found');
        }

        $user = $result->fetch_assoc();
        if (!password_verify($password, $user['User_Password'])) {
            return $this->jsonResponse('error', 'Incorrect password');
        }

        return $this->jsonResponse('success', 'Login successful', ['User_ID' => $user['User_ID'], 'Email' => $user['Email_Address'], 'First_Name' => $user['First_Name']]);
    }
}

// Usage
$api = new API($mysqli);
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No input data']);
    exit();
}

$type = $data['type'] ?? '';
switch ($type) {
    case 'Register':
        $firstName = $data['First_Name'] ?? '';
        $lastName = $data['Last_Name'] ?? '';
        $email = $data['Email_Address'] ?? '';
        $password = $data['User_Password'] ?? '';
        $dob = $data['Date_of_Birth'] ?? '';
        $adminPrivileges = $data['Admin_Privileges'] ?? 0;
        echo $api->register($firstName, $lastName, $email, $password, $dob, $adminPrivileges);
        break;
    case 'Login':
        $email = $data['Email_Address'] ?? '';
        $password = $data['User_Password'] ?? '';
        echo $api->login($email, $password);
        break;
    case 'SearchMovieTitles':
        $title = $data['Title'] ?? '';
        echo $api->searchMovieTitles($title);
        break;
    case 'InsertMovieOrSeries':
        $titleName = $data['Title_Name'] ?? '';
        $contentRatingId = $data['Content_Rating_ID'] ?? 0;
        $reviewRating = $data['Review_Rating'] ?? 0;
        $releaseDate = $data['Release_Date'] ?? '';
        $plotSummary = $data['Plot_Summary'] ?? '';
        $image = $data['Image'] ?? '';
        $languageId = $data['Language_ID'] ?? 0;
        $isMovie = $data['isMovie'] ?? 0;
        echo $api->insertMovieOrSeries($titleName, $contentRatingId, $reviewRating, $releaseDate, $plotSummary, $image, $languageId, $isMovie);
        break;
    case 'UpdateMovieOrSeries':
        $titleId = $data['Title_ID'] ?? 0;
        $titleName = $data['Title_Name'] ?? null;
        $contentRatingId = $data['Content_Rating_ID'] ?? null;
        $reviewRating = $data['Review_Rating'] ?? null;
        $releaseDate = $data['Release_Date'] ?? null;
        $plotSummary = $data['Plot_Summary'] ?? null;
        $image = $data['Image'] ?? null;
        $languageId = $data['Language_ID'] ?? null;
        $isMovie = $data['isMovie'] ?? null;
        echo $api->updateMovieOrSeries($titleId, $titleName, $contentRatingId, $reviewRating, $releaseDate, $plotSummary, $image, $languageId, $isMovie);
        break;
    case 'DeleteMovieOrSeries':
        $titleId = $data['Title_ID'] ?? null;
        $titleName = $data['Title_Name'] ?? null;
        echo $api->deleteMovieOrSeries($titleId, $titleName);
        break;
    case 'GetDetails':
        $titleId = $data['Title_ID'] ?? null;
        $titleName = $data['Title_Name'] ?? null;
        echo $api->getDetails($titleId, $titleName);
        break;
    case 'HashExistingPasswords':
        echo $api->hashExistingPasswords();
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid request type']);
}
?>


