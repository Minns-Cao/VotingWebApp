<?php 
    class User{
        public $username;
        public $email;
        public $password;

        //constructor
        public function __construct($username, $email, $password){
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
        }
    }
?>