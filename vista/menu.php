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
  <img src="../vista/img/pantalla2.jpg" class="rounded" alt="pantalla2" width="100%" height="500" style="margin-top: 30px;">
  <img src="../vista/img/ITMICON.png" class="rounded" alt="ITMICON" width="30%" height="100%" style="margin: 30px auto 0 auto; display: block;">
</div>
<?php include "../vista/basePie.html" ?>