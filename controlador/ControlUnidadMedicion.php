<?php

$objControl = new ControlEntidad('unidadmedicion');
$arreglounidadmedicion = $objControl->listar();

$accion = $_POST['accion'] ?? '';
$id = $_POST['id'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';

switch ($accion) {
    case 'guardar':
        $datos = ['id' => $id, 'descripcion' => $descripcion];
        $obj = new Entidad($datos);
        $objControl->guardar($obj);
        break;
    case 'modificar':
        $datos = ['id' => $id, 'descripcion' => $descripcion];
        $obj = new Entidad($datos);
        $objControl->modificar('id', $id, $obj);
        break;
    case 'borrar':
        $objControl->borrar('id', $id);
        break;
    case 'consultar':
        $obj = $objControl->buscarPorId('id', $id);
        $nombre = $obj->__get('descripcion');
        break;
}
$arreglo = $objControl->listar();

?>