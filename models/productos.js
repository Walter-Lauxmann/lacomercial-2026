import { obtenerToken } from './auth.js';

// URL para acceder a la API
const URL = './api/datos.php?tabla=productos';

/**
 * Genera las cabeceras HTTP incluyendo el Token JWT si existe
 */
function obtenerHeaders() {
    const token = obtenerToken();
    const headers = {};
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }
    return headers;
}

/**
* Selecciona los productos de la BD
*/
export async function seleccionarProductos() {
    let res = await fetch(`${URL}&accion=seleccionar`, {
        headers: obtenerHeaders()
    });
    let datos = await res.json();
    if(res.status !== 200) {
        throw Error('Los datos no se encontraron');
    }
    return datos;
}

/**
 * Inserta los datos en la BD
 * @param {*} datos : Los datos a insertar
 */
export async function insertarProducto(datos) {
    let res = await fetch(`${URL}&accion=insertar`, {
        method: 'POST',
        headers: obtenerHeaders(),
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        return data;
    });
    return res;
}

/**
 * Actualiza los datos en la Base de Datos
 * @param datos los datos a actualizar
 * @param id el id del artículo
 */
export const actualizarProducto = async (datos, id) => {
    let res = await fetch(`${URL}&accion=actualizar&id=${id}`, {
        method: 'POST',
        headers: obtenerHeaders(),
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        return data;
    });
    return res;
}

/**
 * Elimina los datos en la Base de Datos
 * @param id el id del artículo
 */
export const eliminarProducto = async (id) => {
    const res = await fetch(`${URL}&accion=eliminar&id=${id}`, {
        method: 'GET',
        headers: obtenerHeaders()
    });
    return await res.json();
}
