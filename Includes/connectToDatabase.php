<?php
$username = 'root';
$password = 'root';
$db = 'bdowolf_database';
$host = 'localhost';
$port = 8890;

$conn = new mysqli("localhost", "root", "root", "bdowolf_database", 8890);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

}
?>
