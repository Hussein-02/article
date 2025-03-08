<?php

class UserSkeleton
{

    private $id;
    private $fullname;
    private $email;
    private $password;

    public function __construct($id = null, $fullname = null, $email = null, $password = null)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
    }

    //getters/setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFullName()
    {
        return $this->fullname;
    }

    public function setFullName($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    //crud methods to be implemented in model
    public function save()
    {
        //implement
    }

    public function findByEmail($email)
    {
        //implement
    }

    public function all()
    {
        //implement
    }

    public function delete()
    {
        //implement
    }
}
