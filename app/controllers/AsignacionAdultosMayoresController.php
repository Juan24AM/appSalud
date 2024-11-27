<?php

namespace App\Controllers;

use App\Models\AdultoMayor;
use App\Config\Database;

class AsignacionAdultosMayoresController {
    private $db;

    public function __construct($dbConnection) {
        session_start();
        $this->db = $dbConnection;
        if (!isset($_SESSION['nombre']) || !isset($_SESSION['dni'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function mostrarFormularioRegistro() {
        include __DIR__ . '/../views/registrarAdultoMayor.php';
    }

    public function registrarAdultoMayor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $departamento = $_POST['departamento'];
            $provincia = $_POST['provincia'];
            $ciudad = $_POST['ciudad'];
            $direccion = $_POST['direccion'];
            $sexo = $_POST['sexo'];
            $estatura = $_POST['estatura'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $tipo_de_sangre = $_POST['tipo_de_sangre'];
            $padecimientos = $_POST['padecimientos'];

            $responsable_id = $_SESSION['user_id'];

            $adultoMayor = new AdultoMayor($this->db);
            $result = $adultoMayor->guardar($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $direccion, $sexo, $estatura, $fecha_nacimiento, $tipo_de_sangre, $padecimientos, $responsable_id);

            if ($result) {
                $_SESSION['successMessage'] = 'Adulto mayor registrado exitosamente.';
                header("Location: " . BASE_URL . "/asignar_adultos_mayores");
                exit();
            } else {
                $_SESSION['errorMessage'] = 'Error al registrar el adulto mayor. Puede que ya exista.';
                $this->mostrarFormularioRegistro();
            }
        } else {
            $this->mostrarFormularioRegistro();
        }
    }
}