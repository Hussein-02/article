<?php

$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "article_project";

$conn = new mysqli($server_name, $username, $password, $db_name);

if ($conn->connect_error) {
    die("connection failed" . $conn->connect_error);
}

// username in ec2:hussein
// password in ec2:12345678