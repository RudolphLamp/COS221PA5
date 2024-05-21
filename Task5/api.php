<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'config.php';
class API {
    

    public function register($firstName, $lastName, $email, $password, $dateOfBirth, $adminPrivileges) {
        global $mysqli;
        // Validate the email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['status' => 'error', 'message' => 'Invalid email']);
        }
        // Validate the password
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            return json_encode(['status' => 'error', 'message' => 'Password must have at least 8 characters with at least one uppercase letter, one number, one special character, and one lowercase letter.']);
        }
        // Check if the user already exists
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
    
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Insert the new user into the database
        $stmt = $mysqli->prepare("INSERT INTO User_Account (First_Name, Last_Name, Email_Address, User_Password, Date_of_Birth, Admin_Privileges) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $hashed_password, $dateOfBirth, $adminPrivileges);
        if ($stmt->execute() === false) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
    
        // Get the ID of the newly created user
        $userID = $mysqli->insert_id;
    
        // Prepare the success message
        $message = $adminPrivileges ? 'Admin successfully created' : 'User successfully created';
        return json_encode(['status' => 'success', 'timestamp' => round(microtime(true) * 1000), 'data' => ["User_ID" => $userID, "Email" => $email, "First_Name" => $firstName, "message" => $message]]);
    }
  
    
  
    public function searchMovieTitles($title) {
        global $mysqli;
    
        // Prepare the SQL statement
        $stmt = $mysqli->prepare("SELECT Title_ID, Title_Name FROM title WHERE Title_Name LIKE ?");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
    
        // Bind the title parameter
        $title = '%' . $title . '%';
        $stmt->bind_param("s", $title);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch all the matching titles
        $titles = $result->fetch_all(MYSQLI_ASSOC);
    
        return json_encode(['status' => 'success', 'data' => $titles]);
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



    public function login($email, $password) {
        global $mysqli;
    
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $mysqli->prepare("SELECT * FROM User_Account WHERE Email_Address = ?");
        if (!$stmt) {
            return json_encode(['status' => 'error', 'message' => 'Database error: ' . $mysqli->error]);
        }
    
        // Bind the email parameter
    
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
    
            // Verify the password
            if (password_verify($password, $user['User_Password'])) {
                // Remove the password from the user data
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
} 
elseif ($data['type'] == 'SearchTitles') {
    echo $api->searchMovieTitles($data['Title_Name']);
}



?>

<!--  
--------------------------------
    For Register:
--------------------------------
    {
    "type": "Register",
    "First_Name": "John",
    "Last_Name": "Doe",
    "Email_Address": "john.doe@example.com",
    "User_Password": "SecurePassword123!",
    "Date_of_Birth": "1990-01-01",
    "Admin_Privileges": 0
} -->


<!-- 
--------------------------------
    For Login:
--------------------------------


{
    "type": "Login",
    "Email_Address": "john.doe@example.com",
    "User_Password": "SecurePassword123!"
} -->


<!-- 
Added an function to hash all the existing passwords in the database,
 but since wheatley is ratelimited you must go change the,
 Between 0 and 365 in increaments of 350. 
 so The next one will be 350 to 700 and so on.
----------------------------------------------------------------
    For HashPasswords:    NB!!!!! 
    ONLY RUN THIS ONCE 
    WE WILL REMOVE AFTER EVENONE HASHED THEIR PASSWORDS 
----------------------------------------------------------------
{
    "type": "HashPasswords"
} -->


<!-- 
    Search now implemented not sure what it must return? 
    I just returned the Title_ID and Title_Name    
    with fuzzy search so no need to do recommended search
{
    "type": "SearchTitles",
    "Title_Name": "Attack"
} -->
