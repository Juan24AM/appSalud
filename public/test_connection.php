<?php
require_once '../config/database.php';

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Conexión exitosa";
} else {
    echo "Error de conexión";
}
?>
