<?php
session_start();


session_unset();
session_destroy();

header("Location: /appSalud/app/views/auth/login.php");
exit();
?>