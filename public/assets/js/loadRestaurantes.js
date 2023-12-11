// loadRestaurantes.js

document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM completamente cargado y analizado");
});
function cargarRestaurantes(action, id_restaurante, tipo_comida, nombre) {
    console.log(`Cargando restaurantes con acción`);

    const payload = {
        "route": 'restaurante',
        "action": action,
        ...id_restaurante,
        ...tipo_comida,
        ...nombre
    };

    fetch('/sancocho/index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        console.log("Respuesta recibida del servidor");
        return response.json();
    })
    .then(result => {
        console.log("Procesando el resultado: ", result);

        if (result.status === 404)   {
            mostrarMensajeError('No se encontraron restaurantes');
            console.log("No se encontraron restaurantes: ", result.data.message);
            mostrarErrorRestaurante();
            return;
        }

        ocultarErrorRestaurante();

        if (result.status === 200) {
            mostrarMensajeExito('Restaurantes cargados exitosamente');
            console.log("Datos de restaurantes: ", result.data);
            if (document.querySelector('.carousel-track')) {
                mostrarRestaurantesEnSlide(result.data);
            }
            if (document.getElementById('restaurantesContainer')) {
                mostrarRestaurantes(result.data);
            }
        } else {
            console.log("Error al cargar los restaurantes: ", result.data.message);
            mostrarMensajeError(result.data.message);
        }
    })
    .catch(error => {
        mostrarMensajeError('Hubo un problema con la operación fetch: ' + error.message);
        console.error('Hubo un problema con la operación fetch:', error);
    });
}


function mostrarRestaurantesEnSlide(restaurantes) {
    const track = document.querySelector('.carousel-track');
    track.innerHTML = '';

    restaurantes.forEach(restaurante => {
        const li = document.createElement('li');
        li.classList.add('carousel-slide');
        li.innerHTML = generarTarjetaRestaurante(restaurante);
        track.appendChild(li);
    });
}

function mostrarRestaurantes(restaurantes) {
    const container = document.getElementById('restaurantesContainer');
    container.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos elementos

    restaurantes.forEach(restaurante => {
        const cardHTML = generarTarjetaRestaurante(restaurante);
        container.innerHTML += cardHTML; 
    });
}


function generarTarjetaRestaurante(restaurante) {
    const isClosed = !restaurante.estaAbierto;
    const reservaBtnClass = isClosed ? 'disabled' : '';
    const estadoClass = isClosed ? 'closed' : 'open';
    const estadoTexto = isClosed ? 'El restaurante se encuentra cerrado.' : ' ';

    return `
<div class="restaurante-card">
    <img src="/sancocho/public/assets/img/${restaurante.imagen}" alt="${restaurante.nombre}" class="restaurante-img">
    <div class="restaurante-info">
        <h3 class="restaurante-nombre">${restaurante.nombre}</h3>
        <p class="restaurante-descripcion">${restaurante.descripcion}</p>
        <div class="restaurante-estado">
            <i class="fas fa-circle"> </i>
            <span class="${estadoClass}">
                ${estadoTexto}
            </span>
        </div>
        <div class="restaurante-direccion">
            <i class="fas fa-map-marker-alt"></i>
            <span>${restaurante.direccion}</span>
        </div>
        <div class="restaurante-actions">
            <button class="btn reserva-btn ${reservaBtnClass}" ${reservaBtnClass}>Hacer Reserva</button>
            <button class="btn ver-mas-btn" onclick="window.location.href='../../restaurante/${restaurante.idRestaurante}'">Ver Más</button>
        </div>
    </div>
</div>
    `;
}

function mostrarErrorRestaurante() {
    const errorContainer = document.getElementById('errorContainer');
    if (errorContainer) {
        errorContainer.innerHTML = `
        <div class="mensaje-error">
            <h3>No se encontraron restaurantes</h3>
            <p>Lo sentimos, no se encontraron restaurantes con los criterios de búsqueda seleccionados.</p>
        </div>
        `;
        errorContainer.style.display = 'block';
    }
}
function mostrarMensajeError(mensaje) {
    console.log("Mostrando mensaje de error: ", mensaje);
    // Aquí debes asegurarte de que tengas un lugar en tu HTML para mostrar el mensaje de error
    const errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        errorMessage.textContent = mensaje;
        errorMessage.style.display = 'block'; 
    }
}

function mostrarMensajeExito(mensaje) {
    console.log("Mostrando mensaje de éxito: ", mensaje);
    // Aquí debes asegurarte de que tengas un lugar en tu HTML para mostrar el mensaje de éxito
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        successMessage.textContent = mensaje;
        successMessage.style.display = 'block'; 
    }
}
function ocultarErrorRestaurante() {
    const errorContainer = document.getElementById('errorContainer');
    if (errorContainer) {
        errorContainer.style.display = 'none'; // Se oculta cuando no hay error
    }
}