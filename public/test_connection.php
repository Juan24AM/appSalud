<?php
require_once '../config/database.php';
use App\Config\Database;

$database = new Database();

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Conexión exitosa";
} else {
    echo "Error de conexión";
}
?>
