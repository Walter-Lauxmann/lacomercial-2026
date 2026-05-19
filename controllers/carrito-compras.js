
function agregar(boton) {
  // 1. Subimos hasta el contenedor principal del producto
  const articulo = boton.closest('.servicio');

  // 2. Extraemos los datos del producto
  const codigo = articulo.querySelector('[name="codigo"]').textContent;
  const nombre = articulo.querySelector('[name="nombre"]').textContent;
  const precio = articulo.querySelector('[name="precio"]').textContent;

  // 3. Verificamos si el producto ya está en la tabla usando el ID dinámico
  const inputCantidadExistente = document.getElementById(`cantidad_${codigo}`);

  if (inputCantidadExistente) {
    // ¡YA EXISTE! En lugar de duplicar, sumamos 1 a la cantidad actual
    let cantidadActual = parseInt(inputCantidadExistente.value);
    inputCantidadExistente.value = cantidadActual + 1;
    
    // Ejecutamos calcular() para que se actualicen los importes automáticamente
    calcular();
    
    return; // Cortamos la ejecución de la función aquí para que no cree una nueva fila
  }

  // 4. SI NO EXISTE, procedemos a crear la nueva fila normalmente
  const tabla = document.getElementById('lista-tabla');
  const nuevaFila = document.createElement('tr');

  nuevaFila.innerHTML = `
    <td data-label="Código">${codigo}</td>
    <td data-label="Nombre">${nombre}</td>
    <td data-label="Cantidad">
      <input type="number" name="cantidad" id="cantidad_${codigo}" value="1" min="1" onchange="calcular()">
    </td>
    <td data-label="Precio">$ <span name="precio-tabla" id="precio_${codigo}">${precio}</span>.-</td>
    <td data-label="Importe">$ <span name="importe" id="importe_${codigo}">${precio}</span>.-</td>
    <td>
      <button class="boton-eliminar" onclick="eliminar(this)">❌</button>
    </td>
  `;

  tabla.appendChild(nuevaFila);
  
  // Opcional: Ejecutamos calcular por si necesitas actualizar un total general al agregar
  calcular(); 
}

function eliminar(boton) {
  // 1. Buscamos la fila (<tr>) que contiene al botón de eliminar presionado
  const fila = boton.closest('tr');
  
  // 2. Eliminamos por completo esa fila del DOM
  fila.remove();
  
  // 3. Volvemos a calcular los totales para actualizar el importe general de la tabla
  calcular();
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