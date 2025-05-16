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
$tabla = 'indicador';
$clave = 'id';

// Inicializar valores
$accion = $_POST['accion'] ?? '';
$id = $_POST['id'] ?? '';
$codigo = $_POST['codigo'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$objetivo = $_POST['objetivo'] ?? '';
$alcance = $_POST['alcance'] ?? '';
$formula = $_POST['formula'] ?? '';
$fkidtipoindicador = $_POST['fkidtipoindicador'] ?? '';
$fkidunidadmedicion = $_POST['fkidunidadmedicion'] ?? '';
$meta = $_POST['meta'] ?? '';
$fkidsentido = $_POST['fkidsentido'] ?? '';
$fkidfrecuencia = $_POST['fkidfrecuencia'] ?? '';
$fkidarticulo = $_POST['fkidarticulo'] ?? '';
$fkidliteral = $_POST['fkidliteral'] ?? '';
$fkidnumeral = $_POST['fkidnumeral'] ?? '';
$fkidparagrafo = $_POST['fkidparagrafo'] ?? '';

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
          $nombre = $obj->__get('nombre');
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
  <div class="table-wrapper" style="overflow-x: auto;">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-8" style="color:black"><h2>Indicador</h2></div>
        <div class="col-sm-4 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregar">
            <i class="fa fa-plus"></i> Nuevo Indicador</button>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>Id</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Objetivo</th>
          <th>Alcance</th>
          <th>Fórmula</th>
          <th>Tipo Indicador</th>
          <th>Unidad Medición</th>
          <th>Meta</th>
          <th>Sentido</th>
          <th>Frecuencia</th>
          <th>Artículo</th>
          <th>Literal</th>
          <th>Numeral</th>
          <th>Parágrafo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
       <?php foreach ($arreglo as $obj): ?>
        <tr>
          <td><?= $obj->__get('id') ?></td>
          <td><?= $obj->__get('codigo') ?></td>
          <td><?= $obj->__get('nombre') ?></td>
          <td><?= $obj->__get('objetivo') ?></td>
          <td><?= $obj->__get('alcance') ?></td>
          <td><?= $obj->__get('formula') ?></td>
          <td><?= $obj->__get('fkidtipoindicador') ?></td>
          <td><?= $obj->__get('fkidunidadmedicion') ?></td>
          <td><?= $obj->__get('meta') ?></td>
          <td><?= $obj->__get('fkidsentido') ?></td>
          <td><?= $obj->__get('fkidfrecuencia') ?></td>
          <td><?= $obj->__get('fkidarticulo') ?></td>
          <td><?= $obj->__get('fkidliteral') ?></td>
          <td><?= $obj->__get('fkidnumeral') ?></td>
          <td><?= $obj->__get('fkidparagrafo') ?></td>
          <td>
            <form method="post" action="vistaIndicador.php" style="display:inline;">
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
    <form method="POST" action="vistaIndicador.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $accion == 'consultar' ? 'Modificar' : 'Nuevo' ?> Indicador</h5>
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
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" value="<?= $codigo ?>" required>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $nombre ?>" required>
          </div>
          <div class="form-group">
            <label>Objetivo</label>
            <input type="text" name="objetivo" class="form-control" value="<?= $objetivo ?>" required>
          </div>
          <div class="form-group">
            <label>Alcance</label>
            <input type="text" name="alcance" class="form-control" value="<?= $alcance ?>" required>
          </div>
          <div class="form-group">
            <label>Fórmula</label>
            <input type="text" name="formula" class="form-control" value="<?= $formula ?>" required>
          </div>
          <div class="form-group">
            <label>Tipo de Indicador</label>
            <input type="text" name="fkidtipoindicador" class="form-control" value="<?= $fkidtipoindicador ?>" required>
          </div>
          <div class="form-group">
            <label>Unidad de Medición</label>
            <input type="text" name="fkidunidadmedicion" class="form-control" value="<?= $fkidunidadmedicion ?>" required>
          </div>
          <div class="form-group">
            <label>Meta</label>
            <input type="text" name="meta" class="form-control" value="<?= $meta ?>" required>
          </div>
          <div class="form-group">
            <label>Sentido</label>
            <input type="text" name="fkidsentido" class="form-control" value="<?= $fkidsentido ?>" required>
          </div>
          <div class="form-group">
            <label>Frecuencia</label>
            <input type="text" name="fkidfrecuencia" class="form-control" value="<?= $fkidfrecuencia ?>" required>
          </div>
          <div class="form-group">
            <label>Artículo</label>
            <input type="text" name="fkidarticulo" class="form-control" value="<?= $fkidarticulo ?>" required>
          </div>
          <div class="form-group">
            <label>Literal</label>
            <input type="text" name="fkidliteral" class="form-control" value="<?= $fkidliteral ?>" required>
          </div>
          <div class="form-group">
            <label>Numeral</label>
            <input type="text" name="fkidnumeral" class="form-control" value="<?= $fkidnumeral ?>" required>
          </div>
          <div class="form-group">
            <label>Parágrafo</label>
            <input type="text" name="fkidparagrafo" class="form-control" value="<?= $fkidparagrafo ?>" required>
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