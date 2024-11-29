<?php

namespace App\Models;

require_once(__DIR__ . '/../../config/database.php');
use PDO;
use PDOException;

class Adult {
    private $conn;
    private $table_name = "adultoMayor";

    public function __construct() {
        $database = new \App\Config\Database();
        $this->conn = $database->getConnection();
    }

    public function insertOlderAdult($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $direccion, $sexo, $estatura, $fecha_nacimiento, $tipo_de_sangre, $padecimientos, $responsable_id) {
        try {
            $query = "CALL InsertarAdultoMayor(:dni, :nombres, :apellidos, :email, :telefono, :departamento, :provincia, :ciudad, :direccion, :sexo, :estatura, :fecha_nacimiento, :tipo_de_sangre, :padecimientos, :responsable_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':departamento', $departamento, PDO::PARAM_STR);
            $stmt->bindParam(':provincia', $provincia, PDO::PARAM_STR);
            $stmt->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
            $stmt->bindParam(':estatura', $estatura, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_de_sangre', $tipo_de_sangre, PDO::PARAM_STR);
            $stmt->bindParam(':padecimientos', $padecimientos, PDO::PARAM_STR);
            $stmt->bindParam(':responsable_id', $responsable_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "Adulto mayor registrado correctamente";
            }
            return "Error al registrar adulto mayor";
        } catch (PDOException $e) {
            error_log("Error en el registro de adulto mayor: " . $e->getMessage());
            return "Error: " . $e->getMessage();
        }
    }

    public function getSeresQueridos($responsable_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE responsable_id = :responsable_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':responsable_id', $responsable_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function showDevicesPerson($id_usuario) {
        $query = "SELECT am.id AS id_adultoMayor, am.nombres AS nombre_adulto, am.apellidos AS apellido_adulto, am.fecha_nacimiento, d.dispositivo_id, d.alias, d.ultima_fecha_actualizacion 
                  FROM " . $this->table_name . " am 
                  LEFT JOIN dispositivo d ON am.id = d.adulto_mayor_id 
                  WHERE am.responsable_id = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function delAdultoMayor($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Adulto mayor eliminado correctamente";
        }
        return "Error al eliminar adulto mayor";
    }
}