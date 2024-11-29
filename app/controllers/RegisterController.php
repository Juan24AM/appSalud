<?php
namespace App\Controllers;

use App\Models\User;

class RegisterController {
    public function register() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['nombre'])) {
            header("Location: " . BASE_URL . "/dashboard");
            exit();
        }

        $error_message = '';
        $dni_error = '';
        $email_error = '';
        $input = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $sexo = $_POST['sexo'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $telefono = $_POST['telefono'];

            $user = new User();

            // Validaciones
            if (empty($dni) || empty($nombres) || empty($apellidos) || empty($email) || empty($password) || empty($confirm_password)) {
                $error_message = 'Todos los campos son obligatorios.';
            } elseif ($user->existsByDni($dni)) {
                $dni_error = 'Este DNI ya está registrado. Por favor, contacta con soporte.';
            } elseif ($user->existsByEmail($email)) {
                $email_error = 'Este correo electrónico ya está registrado. Por favor, contacta con soporte.';
            } elseif ($password !== $confirm_password) {
                $error_message = 'Las contraseñas no coinciden.';
            } else {
                // Registro de usuario
                if (!$user->register($dni, $nombres, $apellidos, $fecha_nacimiento, $sexo, $email, $password, $telefono)) {
                    $error_message = 'Error en el registro. Por favor, inténtelo de nuevo más tarde.';
                } else {
                    $_SESSION['successMessage'] = 'Registro exitoso. Puedes iniciar sesión ahora.';
                    header("Location: " . BASE_URL . "/login");
                    exit;
                }
            }
        }

        include __DIR__ . '/../views/auth/register.php';
    }
}