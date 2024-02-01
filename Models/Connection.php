<?php

class Connection {
    // Establece los atributos de la case connection.
    private $host;
    private $username;
    private $password;
    private $database;
    public $connection;
    // Se ejecuta un constructor para declarar las variables de la clase y se establece la conexion a la db.
    public function __construct($host , $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connection = mysqli_connect($this->host,$this->username,$this->password,$this->database);
   
  
    }
    // Una funcion con modoficador de acceso publico para realizar consultar en otras clases.
    public function query($query) { 
        $result = mysqli_query($this->connection, $query);
        return $result;
    }
}


