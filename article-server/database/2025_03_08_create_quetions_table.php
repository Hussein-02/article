<?php

require_once __DIR__ . '/../connection/connection.php';

function run_migration($conn)
{
    $sql = "
    CREATE TABLE IF NOT EXISTS questions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question VARCHAR(255) NOT NULL,
        answer VARCHAR(255) NOT NULL
    );
    ";

    if ($conn->query($sql) == TRUE) {
        echo "Questions table created successfullu!";
    } else {
        echo "Error creating table";
    }
}

run_migration($conn);
