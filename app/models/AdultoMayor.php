<?php

namespace App\Models;

use PDO;
use PDOException;

class AdultoMayor
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function guardar($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $direccion, $sexo, $estatura, $fecha_nacimiento, $tipo_de_sangre, $padecimientos, $responsable_id)
    {
        $query = "SELECT COUNT(*) FROM adultoMayor WHERE dni = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$dni]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            return false;
        }

        $query = "INSERT INTO adultoMayor (dni, nombres, apellidos, email, telefono, departamento, provincia, ciudad, direccion, sexo, estatura, fecha_nacimiento, tipo_de_sangre, padecimientos, responsable_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $direccion, $sexo, $estatura, $fecha_nacimiento, $tipo_de_sangre, $padecimientos, $responsable_id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}