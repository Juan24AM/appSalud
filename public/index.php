<?php
require_once __DIR__ . '/../app/controllers/RegisterController.php';
require_once __DIR__ . '/../app/controllers/LoginController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/register':
        $controller = new RegisterController();
        $controller->register();
        break;

    case '/login':
        $controller = new LoginController();
        $controller->login();
        break;
    
    case '/profile':
        $controller = new ProfileController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updateProfile();
        } else {
            $controller->showProfile();
        }
        break;

    case '/':
        require __DIR__ . '/../app/views/templates/index.php';
        break;

    default:
        echo "404 - Página no encontrada";
        break;
}