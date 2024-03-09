<?php 

class User {
    private $id;
    private $nombres;
    private $username;
    private $password;
    private $token;

    public function __construct($id, $nombres, $username, $password, $token) {
        $this->id = $id;
        $this->nombres = $nombres;
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
    public function getToken() {
        return $this->token;
    }
    public function getValues() {
        return array('id'=>$this->id,'nombres'=> $this->nombres,'username'=> $this->username,'password'=> $this->password,'token'=> $this->token);
    }
}