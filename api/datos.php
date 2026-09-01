<?php
// Requerimos el archivo modelos.php
require_once 'modelos.php';

// Si hay un parámetro tabla
if(isset($_GET['tabla'])) {
    $tabla = new Modelo($_GET['tabla']); // Creamos el objeto $tabla   
    
    if(isset($_GET['accion'])) {
        if($_GET['accion'] == 'insertar') {
            $valores = $_POST;
        }

        switch($_GET['accion']) {
            case 'seleccionar':
                $datos = $tabla->seleccionar(); // Ejecutamos el método seleccionar
                echo $datos;
                break;
            case 'insertar':
                $id = $tabla->insertar($valores);

                if($id > 0) {
                    $respuesta = [
                        'success' => true,
                        'message' => 'Registro insertado correctamente',
                        'id' => $id
                    ];                    
                } else {
                    $respuesta = [
                        'success' => false,
                        'message' => 'Error al insertar el registro'
                    ];
                }

                echo json_encode($respuesta);
                break;
        }
    }

    
}
    

?>