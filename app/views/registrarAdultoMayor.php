    <?php include_once __DIR__ . '/templates/header.php'; ?>

        <div class="container">
            <h2>Registrar Adulto Mayor</h2>
            <?php if (isset($_SESSION['successMessage'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['successMessage'];
                    unset($_SESSION['successMessage']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['errorMessage'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['errorMessage'];
                    unset($_SESSION['errorMessage']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo BASE_URL . '/asignar_adultos_mayores'; ?>">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni" required>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>
                <div class="form-group">
                    <label for="departamento">Departamento:</label>
                    <input type="text" class="form-control" id="departamento" name="departamento" required>
                </div>
                <div class="form-group">
                    <label for="provincia">Provincia:</label>
                    <input type="text" class="form-control" id="provincia" name="provincia" required>
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad:</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select class="form-control" id="sexo" name="sexo" required>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estatura">Estatura (cm):</label>
                    <input type="number" class="form-control" id="estatura" name="estatura" required>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
                <div class="form-group">
                    <label for="tipo_de_sangre">Tipo de Sangre:</label>
                    <input type="text" class="form-control" id="tipo_de_sangre" name="tipo_de_sangre" required>
                </div>
                <div class="form-group">
                    <label for="padecimientos">Padecimientos:</label>
                    <textarea class="form-control" id="padecimientos" name="padecimientos"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>

    <?php include_once __DIR__ . '/templates/footer.php'; ?>