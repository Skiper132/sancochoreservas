<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/sancocho/config/session/sessionhandler.php';
if ($isLoggedIn) {
    header('Location: ../home.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../../../public/assets/css/login.css"> <!-- Asegúrate de proveer la ruta correcta al archivo CSS -->
</head>

<body>
    <div class="login-container">
        <img src="../../../public/assets/img/logo.png" alt="Logo" class="logo">
        <div class="login-form-container">
            <form id="loginForm" action="../../../public/index.php" method="post">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="form-submit">
                    <button type="submit">Iniciar Sesión</button>
                </div>
                <div class="error-message" id="errorMessage"></div>
            </form>
            <p>¿No tienes una cuenta? <a href="Registro.php">Regístrate aquí</a>.</p> 
        </div>
    </div>
    <script src="../../../public/assets/js/login.js"></script> 
</body>

</html>