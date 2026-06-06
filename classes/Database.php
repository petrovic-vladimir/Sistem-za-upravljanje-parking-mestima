<?php

class Database
{
    protected $host = 'localhost';
    protected $database = 'parking_system';
    protected $username = 'root';
    protected $password = 'root';
    protected $conn;

    public function connect()
    {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        mysqli_set_charset($this->conn, 'utf8mb4');
        return $this->conn;
    }

    public function getConnection()
    {
        if (!$this->conn) {
            $this->connect();
        }

        return $this->conn;
    }
}
