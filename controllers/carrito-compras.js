
function agregar(boton) {
    // 1. Subimos hasta el contenedor principal (<article>) del producto clicado
    const articulo = boton.closest('.servicio');

    // 2. Extraemos los datos del producto usando querySelector y textContent
    const codigo = articulo.querySelector('[name="codigo"]').textContent;
    const nombre = articulo.querySelector('[name="nombre"]').textContent;
    const precio = articulo.querySelector('[name="precio"]').textContent;

    // 3. Obtenemos la tabla donde vamos a insertar la nueva fila
    const tabla = document.getElementById('lista-tabla');

    // 4. Creamos una nueva fila (tr)
    const nuevaFila = document.createElement('tr');

    // 5. Le metemos la estructura HTML con los datos dinámicos (Template Literals)
    // NOTA: Para los "id" de los inputs y spans, usamos el código del producto para que sean únicos.
    nuevaFila.innerHTML = `
        <td data-label="Código">${codigo}</td>
        <td data-label="Nombre">${nombre}</td>
        <td data-label="Cantidad">
        <input type="number" name="cantidad" id="cantidad_${codigo}" value="1" min="1" onchange="calcular()">
        </td>
        <td data-label="Precio">$ <span name="precio-tabla" id="precio_${codigo}">${precio}</span>.-</td>
        <td data-label="Importe">$ <span name="importe" id="importe_${codigo}">${precio}</span>.-</td>
    `;

    // 6. Agregamos la fila a la tabla
    tabla.appendChild(nuevaFila);
}

function calcular() {
    /* Elementos del DOM */
    const cantidades = document.getElementsByName('cantidad');   
    const precios = document.querySelectorAll('[name="precio-tabla"]');
    const importes = document.querySelectorAll('[name="importe"]');

    /* Variables */
    let total = 0;

    /* Cálculos */
    for(let i=0; i < cantidades.length; i++) {
        const importe = cantidades[i].value * precios[i].textContent;
        total += importe;
        
        /* Mostrar resultados */
        importes[i].textContent = importe;        
        
    }
    document.querySelector('#total').textContent = total;
}