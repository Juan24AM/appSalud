<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localización de Dispositivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('/appSalud/public/images/Fondo_Dashboard.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 1000px;
            margin-top: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.1);
        }

        #user-info, #device-info {
            width: 100%;
            max-width: 800px;
            padding: 25px;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        #user-info:hover, #device-info:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.1em;
            color: #555;
        }

        #map {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .btn-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .btn {
            padding: 12px 25px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            background-color: #4CAF50;
            font-size: 1em;
            margin-right: 15px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #4CAF50;
            transform: scale(1.05);
        }

        #update-time {
            font-size: 0.9em;
            color: #888;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 1.5em;
            }

            p {
                font-size: 1em;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.9em;
                margin-right: 10px;
            }

            #map {
                height: 300px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 15px;
            }

            #user-info, #device-info {
                padding: 15px;
            }

            #map {
                height: 250px;
            }
        }
    </style>
</head>
<body>
<?php
include_once __DIR__ . '/../views/templates/header.php';

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

    <div class="col-md-8">
        <label for="adulto_mayor" class="form-label">Persona</label>
        <select class="form-select" id="adulto_mayor" name="adulto_mayor" required>
            <option value="">Seleccionar Ser Querido</option>
            <?php if (isset($seresQueridosDis) && is_array($seresQueridosDis)): ?>
                <?php foreach ($seresQueridosDis as $persona): ?>
                    <option
                            value="<?php echo htmlspecialchars($persona['id_adultoMayor'] ?? ''); ?>"
                            data-dispositivo="<?php echo htmlspecialchars($persona['dispositivo_id'] ?? ''); ?>"
                            data-nombre="<?php echo htmlspecialchars(($persona['nombre_adulto'] ?? '') . " " . ($persona['apellido_adulto'] ?? '')); ?>"
                    >
                        <?php echo htmlspecialchars(($persona['nombre_adulto'] ?? '') . " " . ($persona['apellido_adulto'] ?? '') . " (" . ($persona['fecha_nacimiento'] ?? '') . ")"); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay seres queridos disponibles</option>
            <?php endif; ?>
        </select>
    </div>

    <div id="device-info" class="mt-4">
        <h2>Información del Dispositivo</h2>
        <p><strong>Nombre:</strong> <span id="device-name">Cargando...</span></p>
        <p><strong>Descripción:</strong> <span id="device-description">Cargando...</span></p>
        <p><strong>Satelites:</strong> <span id="satelites">Cargando...</span></p>
        <p><strong>HDOP:</strong> <span id="hdop">Cargando...</span></p>
        <p><strong>Última Actualización:</strong> <span id="update-time">Cargando...</span></p>
        <div class="btn-container">
            <a href="#" id="share-btn" class="btn">Compartir Ubicación</a>
            <a href="#" id="directions-btn" class="btn">Obtener Indicaciones</a>
        </div>
    </div>

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

    // Ocultar mapa y sección de información al inicio
    document.getElementById('map').style.display = 'none';
    const deviceInfo = document.getElementById('device-info');
    if (deviceInfo) {
        deviceInfo.style.display = 'none';
    }

    // Manejar cambio en el select
    document.getElementById('adulto_mayor').addEventListener('change', async function () {
        const selectedOption = this.options[this.selectedIndex];
        const dispositivoId = selectedOption.getAttribute('data-dispositivo');
        const nombrePersona = selectedOption.getAttribute('data-nombre');

        // Si no se selecciona ninguna persona, ocultar mapa y sección de información
        if (!this.value) {
            document.getElementById('map').style.display = 'none';
            if (deviceInfo) deviceInfo.style.display = 'none';
            return;
        }

        // Si no tiene dispositivo asociado, mostrar alerta y ocultar mapa
        if (!dispositivoId) {
            alert(`La persona seleccionada (${nombrePersona}) no tiene un dispositivo asociado.`);
            document.getElementById('map').style.display = 'none';
            if (deviceInfo) deviceInfo.style.display = 'none';
            return;
        }

        // Si tiene un dispositivo asociado, mostrar mapa y obtener datos del dispositivo
        async function fetchDeviceData() {
            try {
                const response = await fetch(`http://161.132.50.15:5000/api/susalud/geoData?id=${dispositivoId}`);
                if (!response.ok) {
                    throw new Error('Error al obtener datos del dispositivo.');
                }
                const data = await response.json();

                // Mostrar mapa y sección de información
                document.getElementById('map').style.display = 'block';
                if (deviceInfo) deviceInfo.style.display = 'block';

                // Actualizar información en el DOM
                document.getElementById('device-name').textContent = data.nombre || 'Desconocido';
                document.getElementById('device-description').textContent = data.descripcion || 'No disponible';
                document.getElementById('satelites').textContent = (data.satelites != null) ? data.satelites.toString() : 'No disponible';
                document.getElementById('hdop').textContent = (data.hdop != null) ? data.hdop.toString() : 'No disponible';
                document.getElementById('update-time').textContent = new Date().toLocaleString();

                const latitud = data.latitud;
                const longitud = data.longitud;

                // Actualizar marcador y mapa
                marker.setLatLng([latitud, longitud]);
                map.setView([latitud, longitud]);

                // Actualizar enlaces para compartir ubicación e indicaciones
                document.getElementById('share-btn').href = `https://wa.me/?text=Ubicación actual: https://www.google.com/maps?q=${latitud},${longitud}`;
                document.getElementById('directions-btn').href = `https://www.google.com/maps/dir/?api=1&destination=${latitud},${longitud}`;

            } catch (error) {
                console.error("Error al obtener los datos del dispositivo:", error);
                alert("No se pudo obtener la información del dispositivo. Por favor, inténtalo más tarde.");
            }
        }

        // Llamar a la función cada 10 segundos (10000 ms) si el dispositivo tiene datos
        if (dispositivoId) {
            setInterval(fetchDeviceData, 10000);
            fetchDeviceData(); // Llamar inmediatamente para obtener datos al seleccionar
        }
    });
</script>
</body>
</html>