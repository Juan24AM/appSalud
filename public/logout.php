<?php
session_start();


session_unset();
session_destroy();

header("Location: /appSalud/");
exit;


echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cierre de sesión</title>
</head>
<body class="text-center">
    <div class="container mt-5">
        <h2>¡Gracias por utilizar nuestra aplicación!</h2>
        <p>Serás redirigido a la página de inicio en 2 segundos.</p>
        <p><a href="/appSalud/">Volver a la página principal</a></p>
    </div>
</body>
</html>';
?>