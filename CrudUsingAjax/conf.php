<?php 

$host = "localhost";
$user = "root";
$pass = "";
$database = "hotel";

$dsn = "mysql:host=" . $host . ";dbname=" . $database;

$conn = new PDO($dsn, $user, $pass);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


?>
