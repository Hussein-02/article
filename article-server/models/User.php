<?php

require './UserSkeleton.php';
require '../connection/connection.php';

class User extends UserSkeleton
{

    public function save()
    {
        global $conn;

        // $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        $hashedPassword = hash('sha256', $this->getPassword());

        $fullname = $this->getFullName();
        $email = $this->getEmail();
        $id = $this->getId();

        //if exists update the user
        if ($id) {
            $sql = "UPDATE users SET fullname = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $fullname, $email, $hashedPassword, $id);
            $stmt->execute();
        } else {
            //if user deosnt exist insert it
            $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);
            $stmt->execute();

            //set object's id to the created one
            $this->setId($conn->insert_id);
        }
    }
}
