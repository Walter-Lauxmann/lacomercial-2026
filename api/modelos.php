<?php
require_once 'config.php';

class Conexion {
    // Propiedades
    protected $db;

    // Método constructor
    public function __construct() {
        $this->db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

        if( $this->db->connect_errno ) {
            echo 'Fallo al conectar a MySQL: ' . $this->db->connect_error;
            return;
        }

        $this->db->set_charset(DB_CHARSET);
        $this->db->query("SET NAMES 'utf8'");
    }
}


/**
* Clase Modelo basada en la clase Conexion
*/
class Modelo extends Conexion {
    // Propiedades
    private $tabla; // Nombre de la tabla
    private $id = 0; // id del registro
    private $criterio = ''; // Criterio para las consultas
    private $campos = '*'; // Lista de campos
    private $orden = 'id'; // Campos de ordenamiento
    private $limite = 0; // Cantidad de registros
    
    public function __construct($tabla) {
        parent::__construct(); // Ejecuta el constructor padre
        $this->tabla = $tabla; // Guardamos en la propiedad tabla el valor del argumento $tabla
    }

    // Métodos Getter y Setter
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getCriterio() {
        return $this->criterio;
    }
    public function setCriterio($criterio) {
        $this->criterio = $criterio;
    }
    public function getCampos() {
        return $this->campos;
    }
    public function setCampos($campos) {
        $this->campos = $campos;
    }
    public function getOrden() {
        return $this->orden;
    }
    public function setOrden($orden) {
        $this->orden = $orden;
    }
    public function getLimite() {
        return $this->limite;
    }
    public function setLimite($limite) {
        $this->limite = $limite;
    }

    /**
    * Método de selección
    * Permite seleccionar registros de una tabla de BD
    * @return array $resultado
    */
    public function seleccionar() {
        // SELECT * FROM productos WHERE id='10' ORDER BY id LIMIT 10
        $sql = "SELECT {$this->campos} FROM {$this->tabla}";
        // Si hay un criterio, lo agregamos
        if($this->criterio != '') {
            $sql .= " WHERE {$this->criterio}";
        }
        // Agregamos el orden
        $sql .= " ORDER BY {$this->orden}";
        // Si el $limite es > que 0, agregamos el limite
        if($this->limite > 0) {
            $sql .= " LIMIT {$this->limite}";
        }
        // echo $sql; // Mostramos la instrucción SQL
        // Ejecutamos la instrucción SQL
        $resultado = $this->db->query($sql);
        // Devolvemos los datos
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : []; // Guardamos los datos en un Array asociativo
    }

    /**
     * Inserta un registro en la BD
     * @param array $datos: Los datos a insertar
     * @return int $id: El id del registro insertado
     */
    public function insertar($datos) {
        // INSERT INTO productos (codigo, nombre, descripcion, precio, stock, imagen)
        // VALUES ('201', 'Motorola G9', 'Un gran teléfono', '450000', '30', 'motorola.jpg')
        if(isset($datos['id'])) {
            unset($datos['id']);
        }
        if(isset($datos['password'])) {
            $password = $datos['password'];
            // Generamos el hash seguro (cadena de ~60 caracteres)
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $datos['password'] = $password_hash;
        }

        $campos = implode(",",array_keys($datos));
        $valores = implode("','",array_values($datos));

        $sql = "INSERT INTO {$this->tabla} ($campos) VALUES ('$valores')";
        // echo $sql;
        
        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        } else {
            return 0;
        }
    }

    /**
     * Actualiza un registro en la BD
     * @param $datos: los datos a modificar
     */
    public function actualizar($datos) {
        // UPDATE productos SET codigo='101', nombre='Samsung A56', ... WHERE id='3'
        
        // Si viene la clave 'id', la quitamos para no intentar actualizar la Clave Primaria
        if (isset($datos['id'])) {
            unset($datos['id']);
        }

        // Gestión inteligente de la contraseña
        if (isset($datos['password'])) {
            // Si el campo viene vacío (el usuario solo quería actualizar otros datos)
            if (trim($datos['password']) === '') {
                unset($datos['password']); // La quitamos para NO modificar el hash de la BD
            } else {
                // Si ingresó una nueva contraseña, la hasheamos
                $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
            }
        }
        
        $actualizaciones= [];
        foreach($datos as $key => $value) {
            $actualizaciones[] = "$key='$value'";
        }
        $sql = "UPDATE {$this->tabla} SET " . implode(",", $actualizaciones) . " WHERE {$this->criterio}";
        //echo $sql; // Mostramos la instrucción SQL
        return $this->db->query($sql);
    }

    /**
     * Elimina un registro en la BD
     */
    public function eliminar() {
        // DELETE FROM productos WHERE id='1'
        $sql = "DELETE FROM {$this->tabla} WHERE {$this->criterio}";
        $this->db->query($sql);
    }
}
?>


