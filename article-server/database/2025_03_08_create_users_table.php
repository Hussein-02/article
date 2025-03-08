<?php

require_once '../connection/connection.php';

function run_migration($conn)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    );
    ";

    if ($conn->query($sql) == TRUE) {
        echo "Users table created successfullu!";
    } else {
        echo "Error creating table";
    }
}

run_migration($conn);
