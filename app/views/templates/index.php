<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles-index.css">
    <title>AppSalud - Bienvenido</title>
</head>
<body>
    <?php include_once '../app/views/templates/header.php'; ?>
    
    <div class="hero">
        <div class="overlay"></div>
        <div class="container">
            <h1 class="hero-title">Bienvenido a AppSalud</h1>
            <p class="hero-subtitle">Brindamos dispositivos de geolocalización para personas de tercera edad.</p>
            <p class="hero-text">Ayudamos a cuidar a tus seres queridos brindando seguridad y tranquilidad.</p>
            <div class="btn-group">
                <a href="/register" class="btn btn-primary">Registrar</a>
                <a href="/login" class="btn btn-secondary">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
