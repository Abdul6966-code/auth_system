<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {

    private $host = "localhost";
    private $db_name = "auth_system";
    private $username = "root";
    private $password = "";

    public ?PDO $conn = null;

    public function __construct() {

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
}

?>
