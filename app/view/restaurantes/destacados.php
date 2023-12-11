<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/sancocho/public/assets/css/destacados.css">
</head>
<body>
    <div id="restaurante-carousel" class="carousel">
        <div class="carousel-track-container">
            <ul class="carousel-track">
                <!-- Los elementos del carrusel se cargarán aquí dinámicamente -->
            </ul>
        </div>
        <button class="carousel-button carousel-button-left" onclick="moveSlide(-1)">&#10094;</button>
        <button class="carousel-button carousel-button-right" onclick="moveSlide(1)">&#10095;</button>
    </div>
    <div id="errorContainer"></div>
    
    <script src="/sancocho/public/assets/js/carouselNavigation.js"></script>
    <script src="/sancocho/public/assets/js/loadRestaurantes.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarRestaurantes('getAbiertos');
        });
    </script>
</body>
</html>