<?php
namespace Tudublin;

class User {
    private $userId;
    private $userName;
    private $password;
    private $firstName;
    private $lastName;
    private $gender;
    private $email;
    private $age;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function displayUsers(){
        echo "<br><br>User ID: " .$this->userId .
            "<br> User name: " .$this->userName .
            "<br> Email: " . $this->email .
            "<br> Password: " . $this->password .
            "<br> First name: " . $this->firstName .
            "<br> Last name: " . $this->lastName .
            "<br> Gender: " . $this->gender .
            "<br> Age: " . $this->age;
    }
}

