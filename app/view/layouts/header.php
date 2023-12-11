<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/sancocho/config/session/sessionhandler.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="/sancocho/public/assets/css/header.css">
</head>
<body>
    <header>
        <!-- Aquí iría el código para integrar el logo -->
        <div class="logo">
            <!-- Imaginando que hay un archivo de imagen para el logo en la carpeta de imágenes -->
            <a href="/sancocho/app/view/home.php"><img src="/sancocho/public/assets/img/logo.png" alt="Logo"></a>
        </div>

        <!-- Saludo al usuario si ha iniciado sesión -->
        <?php if ($isLoggedIn): ?>
            <p>Hola, <?php echo htmlspecialchars($nombreUsuario); ?></p>
        <?php endif; ?>

        <!-- Barra de navegación -->
        <nav>
            <ul>
                <!-- Enlace a la lista de restaurantes -->
                <li><a href="/sancocho/app/view/restaurantes.php">Restaurantes</a></li>

                <!-- Si el usuario ha iniciado sesión, mostrar perfil y submenú. Si no, mostrar "Únete" -->
                <?php if ($isLoggedIn): ?>
    <li class="dropdown">
        <a href="#"  class="profile-link">Perfil</a>
        <ul class="dropdown-menu">
            <li><a href="">Mi perfil</a></li>
            <li><a href="">Mis reservas</a></li>
            <li><a href="">Configuración</a></li>
            <li><a href="/sancocho/config/session/logout.php">Cerrar sesión</a></li>
        </ul>
    </li>
<?php else: ?>
    <li><a href="/sancocho/app/view/auth/login.php">Iniciar Sesión</a></li>
    <li><a href="/sancocho/app/view/auth/registro.php">Únete</a></li>
<?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>