<?php
namespace App\Controllers;

session_start();
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Adult.php';

use App\Models\User;
use App\Models\Adult;

class ProfileController {
    private $userModel;
    private $adultModel;

    public function __construct() {
        $this->userModel = new User();
        $this->adultModel = new Adult();

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['nombre']) || !isset($_SESSION['dni'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function showProfile() {
        $dni = $_SESSION['dni'];
        $userData = $this->userModel->getUserByDni($dni);
        $successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : null;
        unset($_SESSION['successMessage']);

        $id_usuario = $_SESSION['user_id'];
        $seresQueridos = $this->adultModel->getSeresQueridos($id_usuario);

        require __DIR__ . '/../views/profile.php'; // Asegúrate de que la vista sea la correcta
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $departamento = $_POST['departamento'];
            $provincia = $_POST['provincia'];
            $ciudad = $_POST['ciudad'];
            $distrito = $_POST['distrito'] ?? null; // Manejo de distrito opcional
            $direccion = $_POST['direccion'];
            $sexo = $_POST['sexo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];

            // Validación de campos obligatorios
            if (empty($nombres) || empty($apellidos) || empty($email) || empty($telefono)) {
                $_SESSION['errorMessage'] = 'Todos los campos son obligatorios.';
                header("Location: /appSalud/profile");
                exit();
            }

            // Actualización del usuario
            if ($this->userModel->updateUser ($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $distrito, $direccion, $sexo, $fecha_nacimiento)) {
                $_SESSION['successMessage'] = 'Los datos se actualizaron satisfactoriamente.';
            } else {
                $_SESSION['errorMessage'] = 'Error al actualizar los datos. Por favor, inténtelo de nuevo.';
            }
            header("Location: /appSalud/profile");
            exit();
        }
    }
}