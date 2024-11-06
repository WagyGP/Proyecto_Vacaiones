// assets/js/inicio_funciones.js

document.addEventListener("DOMContentLoaded", function() {

    // Manejar el envío del formulario de recuperación
    const recuperacionForm = document.getElementById("formulario_recuperacion");
    
    recuperacionForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto
        
        const email = document.getElementById("correo_recuperacion").value;

        // Simulación de envío de correo (esto debe ser manejado en el servidor)
        alert(`Se ha enviado un correo a ${email} con instrucciones para recuperar su contraseña.`);
        
        // Limpiar el campo
        recuperacionForm.reset();
        
        // Redirigir al usuario o mostrar un mensaje adicional si es necesario
        mostrarInicioSesion(); // Volver a la pantalla de inicio de sesión
    });
});

// Funciones para mostrar/ocultar pantallas
function mostrarInicioSesion() {
    document.getElementById("caja_inicio_sesion").style.display = "block";
    document.getElementById("caja_registro").style.display = "none";
    document.getElementById("caja_recuperar_cuenta").style.display = "none";
}

function mostrarRegistro() {
    document.getElementById("caja_inicio_sesion").style.display = "none";
    document.getElementById("caja_registro").style.display = "block";
    document.getElementById("caja_recuperar_cuenta").style.display = "none";
}

function mostrarRecuperacion() {
    document.getElementById("caja_inicio_sesion").style.display = "none";
    document.getElementById("caja_registro").style.display = "none";
    document.getElementById("caja_recuperar_cuenta").style.display = "block";
}

// Inicializar mostrando la pantalla de inicio de sesión
mostrarInicioSesion();