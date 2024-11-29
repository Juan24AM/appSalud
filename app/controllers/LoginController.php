<?php
namespace App\Controllers;

use App\Models\User;

class LoginController {
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Redirigir si ya está autenticado
        if (isset($_SESSION['nombre'])) {
            header("Location: " . BASE_URL . "/dashboard");
            exit();
        }

        $error_message = "";
        $input = "";

        // Procesar el formulario de inicio de sesión
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new User();
            $input = $_POST['input'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validar campos vacíos
            if (empty($input) || empty($password)) {
                $error_message = "Por favor, completa todos los campos.";
            } else {
                // Intentar iniciar sesión
                $result = $user->login($input, $password);

                if ($result) {
                    // Guardar información del usuario en la sesión
                    $_SESSION['user_id'] = $result['id'];
                    $_SESSION['nombre'] = $result['nombres'];
                    $_SESSION['dni'] = $result['dni'];

                    header("Location: " . BASE_URL . "/dashboard");
                    exit();
                } else {
                    $error_message = "Credenciales inválidas";
                }
            }
        }

        // Incluir la vista de inicio de sesión
        include __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Limpiar y destruir la sesión
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit();
    }
}