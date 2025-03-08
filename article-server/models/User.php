<?php

require './UserSkeleton.php';
require '../connection/connection.php';

class User extends UserSkeleton
{
    //create or update user
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

    //find user by id
    public static function find($id)
    {
        global $conn;
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            return new User($row['id'], $row['fullname'], $row['email'], $row['password']);
        }
        return null;
    }

    //get all users
    public static function all()
    {
        global $conn;
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row['id'], $row['fullname'], $row['email'], $row['password']);
        }
        return $users;
    }

    //to delete the user
    public function delete()
    {
        global $conn;
        $id = $this->getId();
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
