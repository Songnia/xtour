<?php

  class Database {
    private $host = "localhost";
    private $db_name = "xtour_db";
    private $username = "root";
    private $password = "";
    private $conn;


    public function getConnection() {
      $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
            exit();
        }
        return $this->conn;
      }
    }
?>