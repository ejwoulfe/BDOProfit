<?php
$username = 'bdoprofit_user';
$password = 'middleEarth@03368!';
$db = 'bdowolf_database';
$host = 'edwoulfe90950.ipagemysql.com';
$conn = new mysqli("edwoulfe90950.ipagemysql.com", "bdoprofit_user", "middleEarth@03368!", "bdowolf_database");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>