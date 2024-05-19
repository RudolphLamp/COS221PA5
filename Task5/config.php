<?php
define('DB_SERVER', 'wheatley.cs.up.ac.za');
define('DB_USERNAME', 'u20598425'); //username aka UXXXXXXXXXX student number
define('DB_PASSWORD', 'xxxxxxxxxxxx');  //myphp password thats in wheatley dbpassword file
define('DB_DATABASE', 'xxxxxxxxx_hoops'); //db name in the myphp


$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$servername = "wheatley.cs.up.ac.za";
$username = "u20598425"; //username aka UXXXXXXXXXX student number
$password = "xxxxxxxxxxxx"; //myphp password thats in wheatley dbpassword file
$dbname = "xxxxxxxxx_hoops"; //db name in the myphp

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>
