<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sancocho Reservas - <?php echo $restaurante->getNombre(); ?></title>
    <link rel="stylesheet" href="/sancocho/public/assets/css/restaurante_detalle.css">
</head>
<body>

<div class="restaurant-container">
    <h1 class="restaurant-title"><?php echo $restaurante->getNombre(); ?></h1>
    <div class="restaurant-info-wrapper">
        <div class="restaurant-image-col">
            <img src="/sancocho/public/assets/img/<?php echo $restaurante->getImagen(); ?>" alt="Foto del Restaurante" class="restaurant-image">
            <div class="restaurant-details">
                <h4>Dirección: <?php echo $restaurante->getDireccion(); ?> </h4>
                <h4>Comida: <?php echo $restaurante->getTipoComida(); ?></h4>
                <h4>Rango de precios: <?php echo $restaurante->getRangoPrecios(); ?></h4>
                <h4>Horario: <?php echo $restaurante->getHorarioAperturaFormateado(); ?> - <?php echo $restaurante->getHorarioCierreFormateado(); ?></h4>
            </div>
        </div>
        <div class="reservation-form-col">
            <h3>Reserva una mesa</h3>
            <form action="ruta_procesamiento_reserva.php" method="post" class="reservation-form">
                <div class="form-field">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required class="form-input">
                </div>
                <div class="form-field">
                    <label for="hora">Hora:</label>
                    <input type="time" id="hora" name="hora" required class="form-input">
                </div>
                <div class="form-field">
                    <label for="personas">Número de Personas:</label>
                    <input type="number" id="personas" name="personas" required class="form-input">
                </div>
                <button type="submit" class="submit-btn">Reservar</button>
            </form>
        </div>
    </div>
    <div class="menu-section">
        <div class="menu-title">
            <h2>Menú del Restaurante</h2>
            <div class="menu-download">
                <a href="ruta_menu_pdf" class="download-btn" download>Descargar Menú Completo</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>