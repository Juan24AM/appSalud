<?php
session_start();

session_unset();
session_destroy();

echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cierre de sesión</title>
</head>
<body class="text-center">
    <div class="container mt-5">
        <h2>¡Gracias por utilizar nuestra aplicación!</h2>
    </div>
</body>
</html>';