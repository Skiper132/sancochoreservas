<?php
// Verificamos si la sesión de usuario ha sido iniciada y si hay un nombre de usuario disponible
session_start();
$isLoggedIn = isset($_SESSION['id_usuario']);
$nombreUsuario = $_SESSION['nombre_usuario'] ?? '';
?>