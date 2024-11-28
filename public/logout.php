<?php
session_start();
session_unset();
session_destroy();

// Redirigir a la página de inicio de sesión usando BASE_URL
header("Location: " . BASE_URL . "/login");
exit();