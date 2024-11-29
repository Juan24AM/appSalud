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
use App\Controllers\DashboardController;
use App\Controllers\LoginController;
use App\Controllers\ProfileController;
use App\Controllers\StaffController;
use App\Controllers\AdultController;
use App\Controllers\DeviceController;
use App\Config\Database;

define('BASE_URL', '/appSalud');

$request = strtok($_SERVER['REQUEST_URI'], '?'); // Quitar parámetros de consulta

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

    case BASE_URL . '/dashboard':
        $controller = new \App\Controllers\AdultController($dbConnection);
        $seresQueridosDis = $controller->showListDevices();
        break;

    case BASE_URL . '/staff':
        $controller = new \App\Controllers\StaffController($dbConnection);
        $controller->showStaff();
        break;

    case BASE_URL . '/add-adult':
        $controller = new AdultController($dbConnection);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->registerAdultoMayor();
        } else {
            $controller->showRegisterForm(); // Asegúrate de tener este método en el controlador
        }
        break;

    case BASE_URL . '/add-device':
        $controller = new DeviceController($dbConnection);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->enlazarDispositivo();
        } else {
            $controller->showRegisterForm(); // Asegúrate de tener este método en el controlador
        }
        break;

    case BASE_URL . '/':
        header("Location: " . BASE_URL . "/login");
        exit();

    default:
        $errorController = new Error404Controller();
        $errorController->show404(); // Manejo de errores 404
        break;
}