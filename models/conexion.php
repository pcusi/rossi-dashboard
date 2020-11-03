<?php

class Conexion
{

    private $host = '';
    private $user = '';
    private $password = '';
    private $database = '';

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname$this->database,
                $this->user, $this->password");
        } catch (PDOException $e) {
            echo "Conexion no exitosa" . $e->getMessage();
        }
    }
}
