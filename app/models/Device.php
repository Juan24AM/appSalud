<?php

namespace App\Models;

require_once(__DIR__ . '/../../config/database.php');
use PDO;
use PDOException;

class Device {
    private $conn;

    public function __construct() {
        $database = new \App\Config\Database();
        $this->conn = $database->getConnection();
    }

    public function enlazarDispositivo($dispositivo_id, $alias, $adulto_id, $responsable_id) {
        try {
            $query = "CALL EnlazarDispositivo(:dispositivo_id, :alias, :adulto_id, :responsable_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':dispositivo_id', $dispositivo_id, PDO::PARAM_STR);
            $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
            $stmt->bindParam(':adulto_id', $adulto_id, PDO::PARAM_INT);
            $stmt->bindParam(':responsable_id', $responsable_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "Dispositivo registrado correctamente";
            }
            return "Error al registrar dispositivo";
        } catch (PDOException $e) {
            error_log("Error al enlazar dispositivo: " . $e->getMessage());
            return "Error: " . $e->getMessage();
        }
    }
}