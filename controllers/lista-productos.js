import { productos as productosIniciales } from '../models/productos.js';

const listaProductos = document.querySelector('#lista-productos');
const btnNuevo = document.getElementById('btn-nuevo-producto');
const dialogo = document.getElementById('dialogo-producto');
const formProducto = document.getElementById('form-producto');
const btnCancelar = document.getElementById('btn-cancelar');
const dialogoTitulo = document.getElementById('dialogo-titulo');
const inputCodigo = document.getElementById('prod-codigo');
const inputModoEdicion = document.getElementById('modo-edicion');

// Obtener productos de localStorage
const obtenerProductos = () => {
    const prodStr = localStorage.getItem('productos');
    if (!prodStr) {
        localStorage.setItem('productos', JSON.stringify(productosIniciales));
        return productosIniciales;
    }
    return JSON.parse(prodStr);
};

// Guardar productos en localStorage
const guardarProductos = (lista) => {
    localStorage.setItem('productos', JSON.stringify(lista));
};

document.addEventListener("DOMContentLoaded", () => {
    mostrarProductos();
    inicializarEventos();
});

const mostrarProductos = () => {
    listaProductos.innerHTML = '';
    const productos = obtenerProductos();
    productos.forEach(producto => {
        listaProductos.innerHTML += `
        <article class="servicio">
          <p>${producto.categoria}</p>
          <h3><span name="codigo">${producto.codigo}</span> - <span name="nombre">${producto.nombre}</span></h3>
          <div class="servicio-icono">
            <img src="./imagenes/productos/${producto.imagen}" alt="${producto.nombre}" onerror="this.src='./imagenes/productos/default.jpg'; this.onerror=null;" />
          </div>
          <p>
            <img src="./imagenes/memory.svg" alt="" />Procesador: ${producto.descripcion.procesador} <br />
            <img src="./imagenes/storage.svg" alt="" />Almacenamiento: ${producto.descripcion.almacenamiento} <br />
            <img src="./imagenes/photo_camera.svg" alt="" />Cámaras: ${producto.descripcion.camaras} <br />
            <img src="./imagenes/aod.svg" alt="" />Pantalla: ${producto.descripcion.pantalla}
          </p>
          <h4>$ <span name="precio">${producto.precio}</span>.-</h4>
          <button class="boton" onclick="agregar(this)">Comprar</button>
          
          <div class="admin-opciones">
            <button class="boton-card-editar" data-codigo="${producto.codigo}">✏️ Editar</button>
            <button class="boton-card-eliminar" data-codigo="${producto.codigo}">🗑️ Eliminar</button>
          </div>
        </article>
        `;
    });
};

// Métodos de administración requeridos
export const insertar = (productoNuevo) => {
    const productos = obtenerProductos();
    const existe = productos.some(p => Number(p.codigo) === Number(productoNuevo.codigo));
    if (existe) {
        alert('Ya existe un producto con el código ' + productoNuevo.codigo);
        return false;
    }
    productos.push(productoNuevo);
    guardarProductos(productos);
    mostrarProductos();
    return true;
};

export const modificar = (codigo, productoModificado) => {
    const productos = obtenerProductos();
    const index = productos.findIndex(p => Number(p.codigo) === Number(codigo));
    if (index !== -1) {
        productos[index] = { ...productos[index], ...productoModificado };
        guardarProductos(productos);
        mostrarProductos();
        return true;
    }
    return false;
};

export const eliminar = (codigo) => {
    if (confirm(`¿Está seguro de que desea eliminar el producto con código ${codigo}?`)) {
        const productos = obtenerProductos();
        const filtrados = productos.filter(p => Number(p.codigo) !== Number(codigo));
        guardarProductos(filtrados);
        mostrarProductos();
        return true;
    }
    return false;
};

// Exponer los métodos al objeto window para pruebas externas
window.insertarProducto = insertar;
window.modificarProducto = modificar;
window.eliminarProducto = eliminar;

// Inicialización de eventos para modal y delegación
const inicializarEventos = () => {
    // Abrir modal de creación
    btnNuevo.addEventListener('click', () => {
        dialogoTitulo.textContent = 'Cargar Producto';
        inputModoEdicion.value = 'false';
        inputCodigo.disabled = false;
        formProducto.reset();
        dialogo.showModal();
    });

    // Cerrar modal
    btnCancelar.addEventListener('click', () => {
        dialogo.close();
    });

    // Delegación de eventos para botones Editar y Eliminar en las tarjetas
    listaProductos.addEventListener('click', (e) => {
        const target = e.target;
        if (target.classList.contains('boton-card-editar')) {
            const codigo = target.dataset.codigo;
            abrirModalModificar(codigo);
        } else if (target.classList.contains('boton-card-eliminar')) {
            const codigo = target.dataset.codigo;
            eliminar(codigo);
        }
    });

    // Envío del formulario
    formProducto.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const codigo = Number(inputCodigo.value);
        const productoData = {
            codigo,
            nombre: document.getElementById('prod-nombre').value,
            categoria: document.getElementById('prod-categoria').value,
            precio: Number(document.getElementById('prod-precio').value),
            imagen: document.getElementById('prod-imagen').value || 'nodisponible.png',
            descripcion: {
                procesador: document.getElementById('prod-procesador').value,
                almacenamiento: document.getElementById('prod-almacenamiento').value,
                camaras: document.getElementById('prod-camaras').value,
                pantalla: document.getElementById('prod-pantalla').value
            }
        };

        const esEdicion = inputModoEdicion.value === 'true';
        let exito = false;
        
        if (esEdicion) {
            exito = modificar(codigo, productoData);
        } else {
            exito = insertar(productoData);
        }

        if (exito) {
            dialogo.close();
        }
    });
};

const abrirModalModificar = (codigo) => {
    const productos = obtenerProductos();
    const producto = productos.find(p => Number(p.codigo) === Number(codigo));
    if (!producto) return;

    dialogoTitulo.textContent = 'Modificar Producto';
    inputModoEdicion.value = 'true';
    
    inputCodigo.value = producto.codigo;
    inputCodigo.disabled = true; // No permitir cambiar código al editar

    document.getElementById('prod-nombre').value = producto.nombre;
    document.getElementById('prod-categoria').value = producto.categoria;
    document.getElementById('prod-precio').value = producto.precio;
    document.getElementById('prod-imagen').value = producto.imagen;
    document.getElementById('prod-procesador').value = producto.descripcion.procesador;
    document.getElementById('prod-almacenamiento').value = producto.descripcion.almacenamiento;
    document.getElementById('prod-camaras').value = producto.descripcion.camaras;
    document.getElementById('prod-pantalla').value = producto.descripcion.pantalla;

    dialogo.showModal();
};
