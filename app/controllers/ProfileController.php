<?php
session_start();
require_once __DIR__ . '/../models/User.php';

class ProfileController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showProfile() {
        if (!isset($_SESSION['dni'])) {
            echo "<p>No has iniciado sesión.</p>";
            echo '<a href="/login" class="btn btn-primary">Iniciar sesión</a>';
            exit;
        }
        $dni = $_SESSION['dni'];
        $userData = $this->userModel->getUserByDni($dni);
        $successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : null;
        unset($_SESSION['successMessage']);

        require __DIR__ . '/../views/templates/profile.php';
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
            $direccion = $_POST['direccion'];
            $sexo = $_POST['sexo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];

            $this->userModel->updateUser($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $direccion, $sexo, $fecha_nacimiento);
            
            $_SESSION['successMessage'] = 'Los datos se actualizaron satisfactoriamente.';
            header("Location: /profile");
            exit();
        }
    }
}