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
    <title>Sancocho Reservas - Registro</title>
    <link rel="stylesheet" href="../../../public/assets/css/registro.css">
</head>

<body>
    <div class="registration-container">
        <img src="../../../public/assets/img/logo.png" alt="Logo" class="logo">
        <div class="registration-form-container">
            <form id="registerForm" action="index.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="form-group">
                    <label for="confirmarContrasena">Confirmar Contraseña</label>
                    <input type="password" id="confirmarContrasena" required>
                </div>
                <div class="form-submit">
                    <button type="submit">Registrarse</button>
                </div>
                <div class="error-message" id="errorMessage"></div>
            </form>
        </div>
    </div>
    <script src="../../../public/assets/js/registro.js"></script>
</body>

</html>