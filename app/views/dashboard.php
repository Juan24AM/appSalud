<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localización de Dispositivo</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../images/4.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 90%;
            max-width: 1000px;
            margin-top: 20px;
            transform: scale(0.9);
            background-color: rgba(255, 255, 255, 0.6);
            border-radius: 8px;
            padding: 20px;
        }
        #user-info, #device-info {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        #map {
            width: 100%;
            height: 400px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        h2 {
            margin-top: 0;
        }
        #update-time {
            font-size: 0.9em;
            color: gray;
        }
        .btn-container {
            margin-top: 15px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-right: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            background-color: #007bff;
            font-size: 0.9em;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
include_once __DIR__ . '/../app/views/templates/header.php';

if (!isset($_SESSION['nombre']) || !isset($_SESSION['dni'])) {
    echo '<div class="container text-center" style="margin-top: 100px;">';
    echo '<h2 class="text-danger">No has iniciado sesión.</h2>';
    echo '<p>Por favor, inicia sesión para continuar.</p>';
    echo '<a href="' . BASE_URL . '/login" class="btn btn-primary btn-lg" style="padding: 15px 30px;">Iniciar sesión</a>';
    echo '</div>';
    exit;
}
?>

<div class="container">
    <div id="user-info">
        <h2>Bienvenido/a</h2>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
        <p><strong>DNI:</strong> <?php echo htmlspecialchars($_SESSION['dni']); ?></p>
    </div>

    <div id="device-info">
        <h2>Información del Dispositivo</h2>
        <p><strong>Nombre:</strong> <span id="device-name">Cargando...</span></p>
        <p><strong>Descripción:</strong> <span id="device-description">Cargando...</span></p>
        <p><strong>Última Actualización:</strong> <span id="update-time">Cargando...</span></p>
        <div class="btn-container">
            <a href="#" id="share-btn" class="btn">Compartir Ubicación</a>
            <a href="#" id="directions-btn" class="btn">Obtener Indicaciones</a>
        </div>
    </ div>

    <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    let map = L.map('map').setView([0, 0], 15);
    let marker = L.marker([0, 0]).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    async function fetchDeviceData() {
        try {
            const response = await fetch('http://161.132.50.15:5000/api/susalud/geoData');
            if (!response.ok) {
                throw new Error('Error en la respuesta de la API');
            }
            const data = await response.json();

            document.getElementById('device-name').textContent = data.nombre;
            document.getElementById('device-description').textContent = data.descripcion;
            document.getElementById('update-time').textContent = new Date().toLocaleString();

            const latitud = data.latitud;
            const longitud = data.longitud;
            marker.setLatLng([latitud, longitud]);
            map.setView([latitud, longitud]);

            document.getElementById('share-btn').href = `https://wa.me/?text=Ubicación actual: https://www.google.com/maps?q=${latitud},${longitud}`;
            document.getElementById('directions-btn').href = `https://www.google.com/maps/dir/?api=1&destination=${latitud},${longitud}`;

        } catch (error) {
            console.error("Error al obtener los datos del dispositivo:", error);
            alert("No se pudo obtener la información del dispositivo. Inténtalo de nuevo más tarde.");
        }
    }

    setInterval(fetchDeviceData, 10000);
    fetchDeviceData();
</script>
</body>
</html>