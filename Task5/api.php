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
    
        // Store the password as plain text (not recommended for production)
        $plain_password = $password;
    
        // Insert the new user into the database
        $stmt = $mysqli->prepare("INSERT INTO User_Account (First_Name, Last_Name, Email_Address, User_Password, Date_of_Birth, Admin_Privileges) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $plain_password, $dateOfBirth, $adminPrivileges);
        if ($stmt->execute() === false) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
    
        // Get the ID of the newly created user
        $userID = $mysqli->insert_id;
    
        // Prepare the success message
        $message = $adminPrivileges ? 'Admin successfully created' : 'User successfully created';
        return json_encode(['status' => 'success', 'timestamp' => round(microtime(true) * 1000), 'data' => ["User_ID" => $userID, "Email" => $email, "First_Name" => $firstName, "message" => $message]]);
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
    
            // Directly compare the plain text password
            if ($password === $user['User_Password']) {
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
