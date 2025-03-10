create database with the following details:
$server_name = "localhost";
$username = "root";
$password = "";
$db_name = "article_project";

run migrations:
php migrations/create_questions_table.php
php migrations/create_users_table.php

run seed:
php seed.php
