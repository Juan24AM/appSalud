<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            background: rgb(99, 39, 120);
            color: white;
            text-align: center;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            position: relative;
        }
        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none;
        }
        .profile-button:hover {
            background: #682773;
        }
        .profile-button:focus, .profile-button:active {
            background: #682773;
            box-shadow: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8;
        }
        .form-control[readonly] {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .labels {
            font-size: 11px;
        }
        #successMessage {
            background: rgba(136, 176, 75, 0.8);
            color: white;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 50%;
            max-width: 400px;
            text-align: center;
            display: none;
        }
        h1 {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }
        i {
            color: #9ABC66;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }
        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/../views/templates/header.php'; ?>
<!-- Bloque de mensaje de éxito -->
<?php if (isset($successMessage)): ?>
    <div id="successMessage" class="alert alert-success">
        <div class="card">
            <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                <i class="checkmark">✓</i>
            </div>
            <h1>¡Éxito!</h1>
            <p>Los datos se actualizaron satisfactoriamente.</p>
        </div>
    </div>
    <script>
        window.onload = function() {
            const successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 500);
            }, 2000);
        }
    </script>
<?php endif; ?>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class=" rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span class="font-weight-bold"><?php echo htmlspecialchars($userData['nombres'] . ' ' . $userData['apellidos']); ?></span>
                <span class="text-black-50"><?php echo htmlspecialchars($userData['email']); ?></span>
                <!-- Botón para registrar adulto mayor -->
                <button type="button" class="btn btn-primary profile-button mt-3" id="registerAdultButton">Registrar Adulto Mayor</button>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Configuración de Perfil</h4>
                </div>
                <form id="profileForm" method="POST" action="/appSalud/profile">
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">DNI</label><input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($userData['dni']); ?>" readonly></div>
                        <div class="col-md-6"><label class="labels">Teléfono</label><input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($userData['telefono']); ?>" readonly></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Nombre</label><input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($userData['nombres']); ?>" readonly></div>
                        <div class="col-md-6"><label class="labels">Apellidos</label><input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($userData['apellidos']); ?>" readonly></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Email</label><input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" readonly></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Departamento</label><input type="text" class="form-control" id="departamento" name="departamento" value="<?php echo htmlspecialchars($userData['departamento']); ?>" readonly></div>
                        <div class="col-md-6"><label class="labels">Ciudad</label><input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($userData['ciudad']); ?>" readonly></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Dirección</label><input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($userData['direccion']); ?>" readonly></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Sexo</label>
                            <select class="form-select" id="sexo" name="sexo" disabled>
                                <option value="M" <?php echo $userData['sexo'] === 'M' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="F" <?php echo $userData['sexo'] === 'F' ? 'selected' : ''; ?>>Femenino</option>
                                <option value="O" <?php echo $userData['sexo'] === 'O' ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="labels">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($userData['fecha_nacimiento']); ?>" readonly>
                        </div>
                    </div>
                    <div id="editButtons" class="d-flex mt-4">
                        <button type="button" class="btn btn-primary profile-button" id ="editButton">Editar</button>
                        <button type="button" class="btn btn-secondary ms-2" id="cancelButton" style="display:none;">Cancelar</button>
                        <button type="submit" class="btn btn-success ms-2" id="saveButton" style="display:none;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editButton = document.getElementById('editButton');
    const cancelButton = document.getElementById('cancelButton');
    const saveButton = document.getElementById('saveButton');
    const profileForm = document.getElementById('profileForm');
    const registerAdultButton = document.getElementById('registerAdultButton');
    let initialValues = {};
    Array.from(profileForm.elements).forEach(element => {
        if (element.id !== 'dni' && element.id !== 'sexo') {
            initialValues[element.id] = element.value;
        }
    });
    editButton.addEventListener('click', () => {
        Array.from(profileForm.elements).forEach(element => {
            if (element.id !== 'dni' && element.id !== 'sexo') {
                element.readOnly = false;
                element.classList.remove('bg-light');
            }
        });
        document.getElementById('sexo').disabled = false;
        editButton.style.display = 'none';
        cancelButton.style.display = 'inline-block';
        saveButton.style.display = 'inline-block';
    });
    cancelButton.addEventListener('click', () => {
        Array.from(profileForm.elements).forEach(element => {
            if (element.id !== 'dni') {
                element.readOnly = true;
                element.classList.add('bg-light');
                if (initialValues[element.id] !== undefined) {
                    element.value = initialValues[element.id];
                }
            }
        });
        document.getElementById('sexo').disabled = true;
        document.getElementById('editButton').style.display = 'block';
        document.getElementById('cancelButton').style.display = 'none';
        document.getElementById('saveButton').style.display = 'none';
    });
    cancelButton.addEventListener('mouseover', () => {
        cancelButton.classList.remove('btn-secondary');
        cancelButton.classList.add('btn-outline-secondary');
    });
    cancelButton.addEventListener('mouseout', () => {
        cancelButton.classList.remove('btn-outline-secondary');
        cancelButton.classList.add('btn-secondary');
    });
    registerAdultButton.addEventListener('click', () => {
        window.location.href = '/appSalud/asignar_adultos_mayores';
    });
</script>
</body>
</html>