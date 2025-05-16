<?php
ob_start();
?>
<?php 
	include '../controlador/configBd.php';
	include '../controlador/ControlEntidad.php';
	include '../controlador/ControlConexionPdo.php';
	include '../modelo/Entidad.php';

  	session_start();
  	if($_SESSION['email']==null)header('Location: ../index.php');

	$permisoParaEntrar=false;
	$listaRolesDelUsuario=$_SESSION['listaRolesDelUsuario'];
	for($i=0;$i<count($listaRolesDelUsuario);$i++){
		if($listaRolesDelUsuario[$i]->__get('nombre')=="admin")$permisoParaEntrar=true;
	}
	if(!$permisoParaEntrar)header('Location: ../vista/menu.php');




// Configurar nombre de la tabla y clave primaria
$tabla = 'variablesporindicador';
$clave = 'id';

// Inicializar valores
$accion = $_POST['accion'] ?? '';
$id = $_POST['id'] ?? '';
$fkidvariable = $_POST['fkidvariable'] ?? '';
$fkidindicador = $_POST['fkidindicador'] ?? '';
$dato = $_POST['dato'] ?? '';
$fkemailusuario = $_POST['fkemailusuario'] ?? '';
$fechadato = $_POST['fechadato'] ?? '';

$control = new ControlEntidad($tabla);

// Ejecutar acción si corresponde
if ($accion) {
  $datos = $_POST;
  unset($datos['accion']); // quitar datos que no son campos
  $entidad = new Entidad($datos);

  if ($accion === 'guardar') {
      $control->guardar($entidad);
  } elseif ($accion === 'modificar') {
      $control->modificar($clave, $id, $entidad);
  } elseif ($accion === 'borrar') {
      $control->borrar($clave, $id);
  } elseif ($accion === 'consultar') {
      $obj = $control->buscarPorId($clave, $id);
      if ($obj) {
          $id = $obj->__get('id');
      }
  }
}

// Obtener todos los registros
$arreglo = $control->listar();

?>

<?php include "../vista/base_ini_head.html" ?>
<?php include "../vista/base_ini_body.html" ?>

<style>
    .table-title{background:white;}
</style>

<div class="container mt-4">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-8" style="color:black"><h2>Variables por indicador</h2></div>
        <div class="col-sm-4 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregar">
            <i class="fa fa-plus"></i> Nueva Variable</button>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>Id</th>
          <th>Id Variable</th>
          <th>Id Indicador</th>
          <th>Dato</th>
          <th>Email Usuario</th>
          <th>Fecha dato</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
       <?php foreach ($arreglo as $obj): ?>
        <tr>
          <td><?= $obj->__get('id') ?></td>
          <td><?= $obj->__get('fkidvariable') ?></td>
          <td><?= $obj->__get('fkidindicador') ?></td>
          <td><?= $obj->__get('dato') ?></td>
          <td><?= $obj->__get('fkemailusuario') ?></td>
          <td><?= $obj->__get('fechadato') ?></td>
          <td>
            <form method="post" action="vistaVarIndicador.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= $obj->__get('id') ?>">
              <input type="hidden" name="accion" value="consultar">
              <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
            </form>
            <form method="post" action="" style="display:inline;">
              <input type="hidden" name="id" value="<?= $obj->__get('id') ?>">
              <input type="hidden" name="accion" value="borrar">
              <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" style="color:black"></i></button>
            </form>
          </td>
        </tr>
       <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal: Agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="vistaVarIndicador.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $accion == 'consultar' ? 'Modificar' : 'Nuevo' ?> Variable indicador</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Id</label>
            <input type="number" name="id" class="form-control" value="<?= $id ?>" <?= $accion == 'consultar' ? 'readonly' : '' ?> required>
          </div>
          <div class="form-group">
            <label>Id Variable</label>
            <input type="text" name="fkidvariable" class="form-control" value="<?= $fkidvariable ?>" required>
          </div>
          <div class="form-group">
            <label>Id Indicador</label>
            <input type="text" name="fkidindicador" class="form-control" value="<?= $fkidindicador ?>" required>
          </div>
          <div class="form-group">
            <label>Dato</label>
            <input type="text" name="dato" class="form-control" value="<?= $dato ?>" required>
          </div>
          <div class="form-group">
            <label>Email Usuario</label>
            <input type="text" name="fkemailusuario" class="form-control" value="<?= $fkemailusuario ?>" required>
          </div>
          <div class="form-group">
            <label>Fecha Dato</label>
            <input type="datetime-local" name="fechadato" class="form-control" value="<?= $fechadato ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <?php if ($accion == 'consultar'): ?>
            <button type="submit" name="accion" value="modificar" class="btn btn-primary">Modificar</button>
          <?php else: ?>
            <button type="submit" name="accion" value="guardar" class="btn btn-success">Guardar</button>
          <?php endif ?>
        </div>
      </div>
    </form>
  </div>
</div>

<?php include "../vista/basePie.html" ?>


<?php if ($accion == 'consultar'): ?>
<script>
  window.onload = function() {
    $('#modalAgregar').modal('show');
  }
</script>
<?php endif; ?>

<?php
  ob_end_flush();
?>