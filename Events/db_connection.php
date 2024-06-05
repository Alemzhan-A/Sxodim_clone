<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "events";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");
?>
