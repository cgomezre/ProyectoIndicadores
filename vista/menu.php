<?php
  session_start();
  if($_SESSION['email']==null)header('Location: ../index.php');
?>
<?php include "../vista/base_ini_head.html" ?>
<?php include "../vista/base_ini_body.html" ?>
<!-- código html adicional -->
<style>
  body {background-color: white;}
</style>
<div class="container">
  <img src="../vista/img/pantalla.jpg" class="rounded" alt="pantalla" width="100%" height="500" style="margin-top: 30px;">
</div>
<?php include "../vista/basePie.html" ?>