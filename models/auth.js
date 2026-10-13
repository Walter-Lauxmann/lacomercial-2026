// models/auth.js
const URL_LOGIN = './api/login.php';

/**
 * Inicia sesión enviando usuario y clave a la API
 * @param {FormData} datosForm - Formulario con 'usuario' y 'password'
 */
export async function login(datosForm) {
    const res = await fetch(URL_LOGIN, {
        method: 'POST',
        body: datosForm
    });

    const data = await res.json();

    if (data.success && data.token) {
        // Guardamos el Token y la información del usuario en sessionStorage
        sessionStorage.setItem('jwt_token', data.token);
        sessionStorage.setItem('usuario_info', JSON.stringify(data.usuario));
    }

    return data;
}

/**
 * Obtiene el token guardado en el navegador
 */
export function obtenerToken() {
    return sessionStorage.getItem('jwt_token');
}

/**
 * Obtiene la información del usuario autenticado
 */
export function obtenerUsuarioActual() {
    const usuario = sessionStorage.getItem('usuario_info');
    return usuario ? JSON.parse(usuario) : null;
}

/**
 * Cierra la sesión eliminando el storage
 */
export function logout() {
    sessionStorage.removeItem('jwt_token');
    sessionStorage.removeItem('usuario_info');
    window.location.reload();
}