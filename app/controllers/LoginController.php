<?php
require_once __DIR__ . '/../models/User.php';

class LoginController {
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }        
        if (isset($_SESSION['nombre'])) {
            header("Location: /dashboard.php");
            exit();
        }

        $error_message = "";
        $input = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new User();
            $input = $_POST['input'];
            $result = $user->login($input, $_POST['password']);
            
            if ($result) {
                $_SESSION['nombre'] = $result['nombres'];
                $_SESSION['dni'] = $result['dni'];

                header("Location: /dashboard.php");
                exit();
            } else {
                $error_message = "Credenciales inválidas";
            }
        }

        include __DIR__ . '/../views/auth/login.php';
    }
}
