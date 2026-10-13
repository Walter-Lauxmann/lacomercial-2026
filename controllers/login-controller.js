import { login } from "../models/auth.js";

// Elementos del DOM
const formLogin = document.querySelector('#form-login');
const alerta = document.querySelector('#alerta');

document.addEventListener('DOMContentLoaded', () => {
    inicializarEventos();
});

const inicializarEventos = () => {
    formLogin.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(formLogin);
        
        try {
            // Llamada al modelo de autenticación
            const respuesta = await login(formData);

            if (respuesta.success) {
                mostrarAlerta('¡Autenticación exitosa! Redirigiendo...', 'success');
                
                // Redirección al catálogo/lista de productos tras guardar en sessionStorage
                setTimeout(() => {
                    window.location.href = 'index.html'; // o el nombre de tu vista principal
                }, 1200);
            } else {
                mostrarAlerta(respuesta.message || 'Credenciales incorrectas', 'danger');
            }
        } catch (error) {
            console.error('Error al iniciar sesión:', error);
            mostrarAlerta('Ocurrió un error al conectar con el servidor', 'danger');
        }
    });
};

/**
 * Define el mensaje de alerta
 * @param {*} mensaje El mensaje a mostrar
 * @param {*} tipo El tipo de alerta (primary, secondary, success, warning, danger, ...)
 */
const mostrarAlerta = (mensaje, tipo) => {
    alerta.innerHTML = `
        <div class="alert alert-${tipo}" role="alert">
            ${mensaje}
        </div>
    `;
};