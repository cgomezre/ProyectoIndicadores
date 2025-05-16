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
$tabla = 'fuentesporindicador';
$clave = 'fkidfuente';

// Inicializar valores
$accion = $_POST['accion'] ?? '';
$fkidfuente = $_POST['fkidfuente'] ?? '';
$fkindicador = $_POST['fkindicador'] ?? '';


$control = new ControlEntidad($tabla);

// Ejecutar acción si corresponde
if ($accion) {
  $datos = $_POST;
  unset($datos['accion']); // quitar datos que no son campos
  $entidad = new Entidad($datos);

  if ($accion === 'guardar') {
      $control->guardar($entidad);
  } elseif ($accion === 'modificar') {
      $control->modificar($clave, $fkidfuente, $entidad);
  } elseif ($accion === 'borrar') {
      $control->borrar($clave, $fkidfuente);
  } elseif ($accion === 'consultar') {
      $obj = $control->buscarPorfkidfuente($clave, $fkidfuente);
      if ($obj) {
          $fkidfuente = $obj->__get('fkidfuente');
          //$nombre = $obj->__get('nombre');
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
        <div class="col-sm-8" style="color:black"><h2>Fuente por indicador</h2></div>
        <div class="col-sm-4 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregar">
            <i class="fa fa-plus"></i> Nueva Fuente por indicador</button>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>Id Fuente</th>
          <th>Id Indicador</th>          
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
       <?php foreach ($arreglo as $obj): ?>
        <tr>
          <td><?= $obj->__get('fkidfuente') ?></td>
          <td><?= $obj->__get('fkidindicador') ?></td>
          
          <td>
            <form method="post" action="vistaFuentesXIndicador.php" style="display:inline;">
              <input type="hidden" name="fkidfuente" value="<?= $obj->__get('fkidfuente') ?>">
              <input type="hidden" name="accion" value="consultar">
              <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
            </form>
            <form method="post" action="" style="display:inline;">
              <input type="hidden" name="fkidfuente" value="<?= $obj->__get('fkidfuente') ?>">
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
    <form method="POST" action="vistaFuentesXIndicador.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $accion == 'consultar' ? 'Modificar' : 'Nuevo' ?> Fuente por indicador</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Id Fuente</label>
            <input type="number" name="fkidfuente" class="form-control" value="<?= $fkidfuente ?>" required>
          </div>
          <div class="form-group">
            <label>Id Indicador</label>
            <input type="number" name="fkidindicador" class="form-control" value="<?= $fkidindicador ?>" <?= $accion == 'consultar' ? 'readonly' : '' ?> required>
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