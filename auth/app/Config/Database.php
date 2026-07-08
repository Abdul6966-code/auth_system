<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{

    private $host = "localhost";
    private $db_name = "auth_system";
    private $username = "root";
    private $password = "";

    public ?PDO $conn = null;

    public function __construct()
    {

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public function fetchData(string $query, array $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query error: " . $e->getMessage());
        }
    }

    public function fetchSingle($query){
        $stmt = $this->conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
