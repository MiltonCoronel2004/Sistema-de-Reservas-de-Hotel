<?php

class Connection {
    public $connection;
    public function __construct($host , $username, $password, $database) {
        $this->connection = mysqli_connect($host,$username,$password,$database);
    }
    public function queryPrepare($query, $value1, $value2, $value3, $value4) { 
        $stmt = mysqli_prepare($this->connection, $query);
        $stmt->bind_param('siss', $value1, $value2, $value3, $value4);
        $stmt->execute();
        $result = $stmt->get_result();
        return $this;
    }

    public function query($query) {
        $result = mysqli_query($this->connection, $query);
        return $result;
    }
}
