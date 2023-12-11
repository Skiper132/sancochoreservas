document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM completamente cargado y analizado");
    const loginForm = document.getElementById('loginForm'); // Asegúrate de que esta ID corresponda a tu formulario de inicio de sesión
    loginForm.addEventListener('submit', (event) => {
        console.log("Formulario de inicio de sesión enviado");
        event.preventDefault();
        iniciarSesion();
    });
});

function iniciarSesion() {
    console.log("Iniciando sesión del usuario");
    const email = document.getElementById('email').value;
    const contrasena = document.getElementById('contrasena').value;

    const data = {
        email: email,
        contrasena: contrasena,
        route: 'usuario',
        action: 'login'
    };

    console.log("Enviando datos al servidor para el inicio de sesión: ", data);

    // Realizar la petición AJAX al controlador
    fetch('../../../index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log("Respuesta recibida del servidor");
        return response.json();
    })
    .then(result => {
        console.log("Procesando el resultado: ", result);
        if (result.status === 200) {
            mostrarMensajeExito('Inicio de sesión exitoso');
            console.log("Inicio de sesión exitoso: ", result.data);
            // Redirigir al usuario a la página de bienvenida o dashboard
            setTimeout(() => {
                window.location.href = '../home.php'; // Cambia esto a la URL de destino después del inicio de sesión
            }, 2000);
        } else {
            console.log("Error en el inicio de sesión: ", result.data.message);
            mostrarMensajeError(result.data.message);
        }
    })
    .catch(error => {
        mostrarMensajeError('Error al procesar la solicitud: ' + error.message);
        console.error("Error al procesar la solicitud: ", error);
    });
}

function mostrarMensajeError(mensaje) {
    console.log("Mostrando mensaje de error: ", mensaje);
    const errorMessage = document.getElementById('errorMessage'); // Asegúrate de que esta ID corresponda al elemento que mostrará los mensajes de error
    errorMessage.textContent = mensaje;
    errorMessage.style.color = 'red';
}

function mostrarMensajeExito(mensaje) {
    console.log("Mostrando mensaje de éxito: ", mensaje);
    const errorMessage = document.getElementById('errorMessage'); // Asegúrate de que esta ID corresponda al elemento que mostrará los mensajes de éxito
    errorMessage.textContent = mensaje;
    errorMessage.style.color = 'green';
}