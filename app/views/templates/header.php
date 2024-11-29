<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="<?= BASE_URL ?>/public/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/images/favicon.ico" type="image/x-icon">
    <link rel="icon" sizes="192x192" href="<?= BASE_URL ?>/public/images/favicon-192x192.png">
    <link rel="icon" sizes="512x512" href="<?= BASE_URL ?>/public/images/favicon-512x512.png">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        /* Paleta de colores */
        :root {
            --primary-color: #28a745;
            --hover-color: #218838;
            --accent-color: #d4edda;
            --background-color: #f4f4f9;
            --text-color: #fff;
        }

        /* Fondo de la página */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
        }

        /* Estilo para la barra de navegación */
        .navbar-custom {
            background-color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .navbar-custom:hover {
            background-color: var(--hover-color);
        }

        /* Estilos para el logo */
        .navbar-brand {
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--text-color) !important;
            text-transform: uppercase;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--accent-color) !important;
            transform: scale(1.1); /* Efecto de ampliación */
        }

        /* Estilo para los links de navegación */
        .nav-link {
            font-size: 1.1rem;
            color: var(--text-color) !important;
            font-weight: 500;
            padding: 10px 20px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
            transform: translateY(-5px); /* Efecto de desplazamiento */
        }

        /* Estilo para el botón de toggle en móvil */
        .navbar-toggler-icon {
            background-color: var(--text-color);
        }

        /* Animaciones del menú colapsado en dispositivos móviles */
        .navbar-collapse {
            transition: all 0.3s ease;
        }

        /* Sombra suave */
        .navbar {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Navbar activo con transición */
        .navbar-nav .nav-item.active .nav-link {
            color: var(--accent-color) !important;
            font-weight: 600;
        }

        /* Para dispositivos móviles */
        @media (max-width: 767px) {
            .navbar-nav {
                background-color: var(--primary-color);
                padding: 10px 0;
            }

            .navbar-toggler {
                border-color: var(--accent-color);
            }

            .navbar-nav .nav-link {
                font-size: 1.2rem;  /* Ajustar el tamaño de los enlaces en móviles */
                padding: 12px 15px;
            }

            .navbar-collapse {
                padding-top: 10px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <a class="navbar-brand" href="/">AppSalud</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/appSalud">Inicio</a>
            </li>
            <?php if (isset($_SESSION['nombre']) && isset($_SESSION['dni'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/appSalud/profile">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/appSalud/staff">Equipo de Trabajo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/logout">Cerrar sesión</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/appSalud/login">Iniciar sesión</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
