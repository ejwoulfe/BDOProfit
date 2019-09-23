<?php
$username = 'root';
$password = 'root';
$db = 'bdowolf_database';
$host = '127.0.0.1';
$port = 3306;
$conn = new mysqli($host, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


