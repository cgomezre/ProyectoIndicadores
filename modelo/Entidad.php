<?php
class Entidad {
    private $propiedades = [];

    function __construct($params = []) {
        $this->propiedades = $params;
    }

    public function __set($nombrecolumna, $valor) {
        $this->propiedades[$nombrecolumna] = $valor;
    }

    public function __get($nombrecolumna) {
        if (array_key_exists($nombrecolumna, $this->propiedades)) {
            return $this->propiedades[$nombrecolumna];
        }
        trigger_error("Propiedad no definida: " . $nombrecolumna, E_USER_NOTICE);
        return null;
    }

    // Método para obtener todas las propiedades
    public function obtenerPropiedades() {
        return $this->propiedades;
    }
}
?>
