<?php
namespace App\Config;

// Cargar variables de entorno
require_once __DIR__ . '/env.php';
loadEnv(__DIR__ . '/../.env'); // Ajusta la ruta si es necesario

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (\PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage());
        }
        return $this->conn;
    }
}