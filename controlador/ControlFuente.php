<?php

$objControl = new ControlEntidad('fuente');
$arreglofuente = $objControl->listar();

$accion = $_POST['accion'] ?? '';
$id = $_POST['id'] ?? '';
$nombre = $_POST['nombre'] ?? '';

switch ($accion) {
    case 'guardar':
        $datos = ['id' => $id, 'nombre' => $nombre];
        $obj = new Entidad($datos);
        $objControl->guardar($obj);
        break;
    case 'modificar':
        $datos = ['id' => $id, 'nombre' => $nombre];
        $obj = new Entidad($datos);
        $objControl->modificar('id', $id, $obj);
        break;
    case 'borrar':
        $objControl->borrar('id', $id);
        break;
    case 'consultar':
        $obj = $objControl->buscarPorId('id', $id);
        $nombre = $obj->__get('nombre');
        break;
}
$arreglo = $objControl->listar();

?>