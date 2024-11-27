<?php
session_start();

require_once __DIR__ . '/app/controllers/RegisterController.php';
require_once __DIR__ . '/app/controllers/LoginController.php';
require_once __DIR__ . '/app/controllers/ProfileController.php';
require_once __DIR__ . '/app/controllers/Error404Controller.php';

define('BASE_URL', '/appSalud');

$request = $_SERVER['REQUEST_URI'];

// Eliminar parámetros de consulta de la URL
$request = strtok($request, '?');

switch ($request) {
    case BASE_URL . '/register':
        $controller = new RegisterController();
        $controller->register();
        break;

    case BASE_URL . '/login':
        $controller = new LoginController();
        $controller->login();
        break;

    case BASE_URL . '/profile':
        $controller = new ProfileController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updateProfile();
        } else {
            $controller->showProfile();
        }
        break;

    case BASE_URL . '/logout':
        $controller = new LoginController();
        $controller->logout();
        break;

    case BASE_URL . '/':
    case BASE_URL:
        // Redirigir a la página de inicio de sesión
        header("Location: " . BASE_URL . "/login");
        exit();

    default:
        $errorController = new Error404Controller();
        $errorController->show404();
        break;
}