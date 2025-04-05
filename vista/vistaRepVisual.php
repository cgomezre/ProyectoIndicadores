<?php
ob_start();
?>
<?php 
	include '../controlador/configBd.php';
	include '../controlador/ControlEntidad.php';
	include '../controlador/ControlConexionPdo.php';
	include '../modelo/Entidad.php';
  include '../controlador/ControlRepVisual.php';
  	session_start();
  	if($_SESSION['email']==null)header('Location: ../index.php');

	$permisoParaEntrar=false;
	$listaRolesDelUsuario=$_SESSION['listaRolesDelUsuario'];
	for($i=0;$i<count($listaRolesDelUsuario);$i++){
		if($listaRolesDelUsuario[$i]->__get('nombre')=="admin")$permisoParaEntrar=true;
	}
	if(!$permisoParaEntrar)header('Location: ../vista/menu.php');

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
        <div class="col-sm-8" style="color:black"><h2>Represen Visual</h2></div>
        <div class="col-sm-4 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregar">
            <i class="fa fa-plus"></i> Nuevo RepresenVisual</button>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
       <?php foreach ($arreglo as $obj): ?>
        <tr>
          <td><?= $obj->__get('id') ?></td>
          <td><?= $obj->__get('nombre') ?></td>
          <td>
            <form method="post" action="" style="display:inline;">
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
    <form method="POST" action="">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $accion == 'consultar' ? 'Modificar' : 'Nuevo' ?> Represen Visual</h5>
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
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $nombre ?>" required>
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