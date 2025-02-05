<?php

namespace App\Models;

class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $created_at;

    public function __construct($id,$username,$email,$password,$created_at) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
    }


    // Getters
    public function getId() {return $this->id;}
    public function getUsername() {return $this->username;}
    public function getEmail() {return $this->email;}
    public function getCreatedAt() {return $this->created_at;}

    // Setters
    public function setId($id) {$this->id = $id; return $this;}
    public function setUsername($username) {$this->username = $username; return $this;}
    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;} return $this; }
    public function setPassword($password) { $this->password = password_hash($password, PASSWORD_DEFAULT); return $this; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; return $this;}
    public function verifyPassword($password) { return password_verify($password, $this->password); }


}