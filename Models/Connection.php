<?php

class Connection {
    private $host;
    private $username;
    private $password;
    private $database;
    public $connection;

    public function __construct($host , $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connection = mysqli_connect($this->host,$this->username,$this->password,$this->database);
   
  
    }

    public function query($query) { 
        $result = mysqli_query($this->connection, $query);
        return $result;
    }
}


