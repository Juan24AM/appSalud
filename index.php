<?php
spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\Controllers\\' => '/app/controllers/',
        'App\\Models\\' => '/app/models/',
        'App\\Config\\' => '/config/'
    ];

    foreach ($prefixes as $prefix => $dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) === 0) {
            $relative_class = substr($class, $len);
            $file = __DIR__ . $dir . $relative_class . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
});

use App\Controllers\Error404Controller;
use App\Controllers\AsignacionAdultosMayoresController;
use App\Config\Database;

define('BASE_URL', '/appSalud');

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

$database = new Database();
$dbConnection = $database->getConnection();

switch ($request) {
    case BASE_URL . '/register':
        $controller = new \App\Controllers\RegisterController($dbConnection);
        $controller->register();
        break;

    case BASE_URL . '/login':
        $controller = new \App\Controllers\LoginController($dbConnection);
        $controller->login();
        break;

    case BASE_URL . '/profile':
        $controller = new \App\Controllers\ProfileController($dbConnection);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updateProfile();
        } else {
            $controller->showProfile();
        }
        break;

    case BASE_URL . '/logout':
        $controller = new \App\Controllers\LoginController($dbConnection);
        $controller->logout();
        break;

    case BASE_URL . '/asignar_adultos_mayores':
        $controller = new AsignacionAdultosMayoresController($dbConnection);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->registrarAdultoMayor();
        } else {
            $controller->mostrarFormularioRegistro();
        }
        break;

    case BASE_URL . '/':
        header("Location: " . BASE_URL . "/login");
        exit();

    default:
        $errorController = new Error404Controller();
        $errorController->show404();
        break;
}