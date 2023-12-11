let indiceActual = 0;
const tarjetasPorVista = 3;

// Si es en movil, mostrar solo una tarjeta por vista
if (window.innerWidth < 768) {
    tarjetasPorVista = 1;
}

function moveSlide(direction) {
    const totalSlides = document.querySelectorAll('.carousel-slide').length;
    indiceActual += direction;

    if (indiceActual >= totalSlides) {
        indiceActual = 0;
    } else if (indiceActual < 0) {
        indiceActual = totalSlides - tarjetasPorVista;
    }
    
    updateCarousel();
}

function updateCarousel() {
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-slide');
    
    if (slides.length > 0) {
        const slideWidth = slides[0].getBoundingClientRect().width;
        track.style.transform = `translateX(-${indiceActual * slideWidth}px)`;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.carousel-button-left').addEventListener('click', function() {
        moveSlide(-1);
    });
    document.querySelector('.carousel-button-right').addEventListener('click', function() {
        moveSlide(1);
    });
});