<?php
define('DB_SERVER', 'wheatley.cs.up.ac.za');
define('DB_USERNAME', 'u20598425'); 
define('DB_PASSWORD', ''); 
define('DB_DATABASE', 'u20598425_hoopsv4');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
