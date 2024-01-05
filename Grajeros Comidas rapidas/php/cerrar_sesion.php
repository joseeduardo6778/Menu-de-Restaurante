<?php
session_start();

// Destruir la sesión actual
session_destroy();

// Redirigir al usuario a la página de inicio o a donde desees
header("Location: login.html");
exit();
?>
