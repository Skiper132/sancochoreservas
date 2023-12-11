document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM completamente cargado y analizado");
    const registerForm = document.getElementById('registerForm'); 
    registerForm.addEventListener('submit', (event) => {
        console.log("Formulario de registro enviado");
        event.preventDefault();
        registrarUsuario();
    });
});

function registrarUsuario() {
    console.log("Iniciando el registro del usuario");
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const contrasena = document.getElementById('contrasena').value;
    const confirmarContrasena = document.getElementById('confirmarContrasena').value;
    const errorMessage = document.getElementById('errorMessage');

    // Validar que las contraseñas coincidan
    if (contrasena !== confirmarContrasena) {
        console.log("Error: las contraseñas no coinciden");
        mostrarMensajeError('Las contraseñas no coinciden');
        return;
    }

    const data = {
        nombre: nombre,
        email: email,
        contrasena: contrasena,
        route: 'usuario',
        action: 'register'
    };

    console.log("Enviando datos al servidor: ", data);

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
            mostrarMensajeExito(result.data.message);
            console.log("Registro exitoso: ", result.data.message);
            // Limpiar formulario después de registro exitoso
            registerForm.reset();
            // Redirigir al usuario a la página de inicio de sesión
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);
        } else {
            mostrarMensajeError(result.data.message);
            console.log("Error en el registro: ", result.data.message);
        }
    })
    .catch(error => {
        mostrarMensajeError('Error al procesar la solicitud: ' + result.data.message);
        console.error("Error al procesar la solicitud: ", error);
    });
}

function mostrarMensajeError(mensaje) {
    console.log("Mostrando mensaje de error: ", mensaje);
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.textContent = mensaje;
    errorMessage.style.color = 'red';
}

function mostrarMensajeExito(mensaje) {
    console.log("Mostrando mensaje de éxito: ", mensaje);
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.textContent = mensaje;
    errorMessage.style.color = 'green';
}