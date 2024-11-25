<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - AppSalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        body {
            background-image: url('/images/3.png');
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
            max-width: 400px;
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
    <h2 class="text-center mb-4">Iniciar sesión</h2>
    <form action="../login" method="POST">
        <input type="text" name="input" placeholder="Correo o DNI"
               class="form-control my-3 <?php echo !empty($error_message) ? 'error-input' : ''; ?>"
               value="<?php echo htmlspecialchars($input); ?>" required>
        <input type="password" name="password" placeholder="Contraseña"
               class="form-control my-3 <?php echo !empty($error_message) ? 'error-input' : ''; ?>" required>

        <?php if (!empty($error_message)): ?>
            <div class="error text-center mt-2"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <button class="btn btn-primary w-100">Iniciar sesión</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>