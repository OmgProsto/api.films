<?php

class Database {

    private $host = "localhost";
    private $db_name = "api_films";
    private $username = "root";
    private $password = "root";
    public $conn;

    static public function getConnection(){


        $this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->db_name);
    

        return $this->conn;
    }
}

?>