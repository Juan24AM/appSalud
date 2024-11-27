<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - AppSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        body {
            background-image: url('/images/2.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .form-container {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        .error-input {
            border-color: red;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2 class="text-center mb-4">Registro</h2>
    <form action="/appSalud/register" method="POST"> <!-- Cambiado a la ruta correcta -->
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" id="dni" name="dni" placeholder="DNI"
                   value="<?php echo isset($dni) ? htmlspecialchars($dni) : ''; ?>"
                   class="form-control <?php echo isset($dni_error) && $dni_error ? 'error-input' : ''; ?>" required>
            <?php if (isset($dni_error) && $dni_error): ?>
                <div class="error mt-1"><?php echo $dni_error; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" id="nombres" name="nombres" placeholder="Nombres"
                   value="<?php echo isset($nombres) ? htmlspecialchars($nombres) : ''; ?>"
                   class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos"
                   value="<?php echo isset($apellidos) ? htmlspecialchars($apellidos) : ''; ?>"
                   class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de nacimiento"
                   value="<?php echo isset($fecha_nacimiento) ? htmlspecialchars($fecha_nacimiento) : ''; ?>"
                   class=" form-control" required>
        </div>
        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select id="sexo" name="sexo" class="form-select" required>
                <option value="">Selecciona el sexo</option>
                <option value="M" <?php echo isset($sexo) && $sexo === 'M' ? 'selected' : ''; ?>>Masculino</option>
                <option value="F" <?php echo isset($sexo) && $sexo === 'F' ? 'selected' : ''; ?>>Femenino</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" id="email" name="email" placeholder="Correo"
                   value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                   class="form-control <?php echo isset($email_error) && $email_error ? 'error-input' : ''; ?>" required>
            <?php if (isset($email_error) && $email_error): ?>
                <div class="error mt-1"><?php echo $email_error; ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" placeholder="Teléfono"
                   value="<?php echo isset($telefono) ? htmlspecialchars($telefono) : ''; ?>"
                   class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>