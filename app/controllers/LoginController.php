<?php
namespace App\Controllers;
use App\Models\User;

class LoginController {
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['nombre'])) {
            header("Location: /appSalud/public/dashboard.php");
            exit();
        }

        $error_message = "";
        $input = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new \App\Models\User();
            $input = $_POST['input'];
            $password = $_POST['password'];

            if (empty($input) || empty($password)) {
                $error_message = "Por favor, completa todos los campos.";
            } else {
                $result = $user->login($input, $password);

                if ($result) {
                    $_SESSION['nombre'] = $result['nombres'];
                    $_SESSION['dni'] = $result['dni'];
                    $_SESSION['user_id'] = $result['id'];

                    header("Location: /appSalud/public/dashboard.php");
                    exit();
                } else {
                    $error_message = "Credenciales inválidas";
                }
            }
        }

        include __DIR__ . '/../views/auth/login.php';
    }
    public function logout() {
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit();
    }
}