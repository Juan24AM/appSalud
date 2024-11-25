<?php
class Database {
    private $host = "161.132.50.15";
    private $db_name = "app_Salud";
    private $username = "adminSalud";
    private $password = "N4vT0$4luD";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // echo "Conexión exitosa";
        } catch (PDOException $exception) {
            //echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}