<?php
// Requerimos el archivo modelos.php
require_once 'modelos.php';

// Si hay un parámetro tabla
if(isset($_GET['tabla'])) {
    $tabla = new Modelo($_GET['tabla']); // Creamos el objeto $tabla
    
    if(isset($_GET['id'])) { // Si está seteado el id
        $tabla->setCriterio("id=" . $_GET['id']); // Establecemos el criterio
    }     
    
    if(isset($_GET['accion'])) {
        if($_GET['accion'] == 'insertar' || $_GET['accion'] == 'actualizar') {
            $valores = $_POST;
        }

        switch($_GET['accion']) {
            case 'seleccionar':
                $datos = $tabla->seleccionar(); // Ejecutamos el método seleccionar
                print_r( $datos );
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

               case 'actualizar':
                $tabla->actualizar($valores); // Ejecutamos el método actualizar
                $respuesta = [
                    'success' => true,
                    'message' => 'Registro actualizado correctamente.'
                ];
                echo json_encode($respuesta);
                break;
                
               case 'eliminar':
                $tabla->eliminar(); // Ejecutamos el método eliminar)
                $respuesta = [
                    'success' => true,
                    'message' => 'Registro eliminado correctamente.'
                ];
                echo json_encode($respuesta);
                break; 
        }
    }

    
}
    

?>