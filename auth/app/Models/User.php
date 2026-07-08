<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User {

    private string $table_name = 'users';
    private PDO $conn;

    public int $id;
    public string $name;
    public string $email;
    public string $password;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conn;
    }

    public function register()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, email, password)
                  VALUES (:name, :email, :password)";

        $stmt = $this->conn->prepare($query);

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        return $stmt->execute();
    }

    public function login()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            $this->id = $user['id'];
            $this->name = $user['name'];
            return true;
        }

        return false;
    }
}