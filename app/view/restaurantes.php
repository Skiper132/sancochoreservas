<?php
include_once 'layouts/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sancocho Reservas - Restaurantes</title>
    <link rel="stylesheet" href="/sancocho/public/assets/css/restaurantes.css">
</head>
<body>
    <header>
        <!-- Aquí puede ir tu barra de navegación y logo -->
    </header>
    <div id="filtros">
        <!-- Filtros para nombre, tipo de comida y estado de apertura -->
        <input type="text" id="nombreFiltro" placeholder="Buscar por nombre...">
        <select id="tipoComidaFiltro">
            <option value="">Seleccionar tipo de comida</option>
            <option value="Italiana">Italiana</option>
            <option value="Panameña">Panameña</option>
            <option value="Brasileña">Brasileña</option>
            <option value="Peruana">Peruana</option>
        </select>
        <label>
            <input type="checkbox" id="abiertoFiltro"> Abierto ahora
        </label>
        <button id="buscarBtn">Buscar</button>
    </div>
    <div id="errorContainer"></div>
    <div id="restaurantesContainer">
        <!-- Aquí se cargarán los restaurantes -->
    </div>
    <script src="/sancocho/public/assets/js/loadRestaurantes.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarRestaurantes('getAll');
        });

        document.getElementById('buscarBtn').addEventListener('click', function() {
            const nombre = document.getElementById('nombreFiltro').value;
            const tipoComida = document.getElementById('tipoComidaFiltro').value;
            const abierto = document.getElementById('abiertoFiltro').checked;

            let action = 'getAll';
            let params = {};

            if (nombre !== '') {
                action = 'getPorNombre';
                params.nombre = nombre;
            }

            if (tipoComida !== '') {
                action = 'getPorTipo';
                params.tipo_comida = tipoComida;
            }

            if (abierto) {
                action = 'getAbiertos';
            }

            cargarRestaurantes(action, {}, params);
        });
    </script>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/sancocho/app/view/layouts/footer.php'; ?>
</body>
</html>