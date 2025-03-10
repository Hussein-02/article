<?php

require __DIR__ . '/UserSkeleton.php';
require __DIR__ . '/../connection/connection.php';

class User extends UserSkeleton
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    //create or update user
    public function save()
    {
        // $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        $hashedPassword = hash('sha256', $this->getPassword());

        $fullname = $this->getFullName();
        $email = $this->getEmail();
        $id = $this->getId();

        //if exists update the user
        if ($id) {
            $sql = "UPDATE users SET fullname = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssi", $fullname, $email, $hashedPassword, $id);
            $stmt->execute();
        } else {
            //if user deosnt exist insert it
            $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);
            $stmt->execute();

            //set object's id to the created one
            $this->setId($this->conn->insert_id);

            $stmt->close();
            return true;
        }
    }

    //find user by email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $user = new User($this->conn);
            $user->setId($row['id']);
            $user->setFullName($row['fullname']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);

            return $user;
        }
        return null;
    }

    //get all users
    public function all()
    {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row['id'], $row['fullname'], $row['email'], $row['password']);
        }
        return $users;
    }

    //to delete the user
    public function delete()
    {
        $id = $this->getId();
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
