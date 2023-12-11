<?php
session_start();
// Vaciar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión.
session_destroy();

// Redirigir al usuario a la página de inicio o a donde prefieras
header("Location: /sancocho/app/view/home.php");
exit();
?>