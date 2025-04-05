<?php
  ob_start();
?>
<?php
include_once 'controlador/configBd.php';
include_once 'controlador/ControlEntidad.php';
include_once 'controlador/ControlConexionPdo.php';
include_once 'modelo/Entidad.php';
session_start();
$email="";
$contrasena="";
$boton="";

if(isset($_POST['txtEmail']))$email=$_POST['txtEmail'];
if(isset($_POST['txtContrasena']))$contrasena=$_POST['txtContrasena'];
if(isset($_POST['btnLogin']))$boton=$_POST['btnLogin'];
if($boton=="Login"){
  $validar=false;
  $sql="SELECT * FROM usuario WHERE email=? AND contrasena=?";
  $objControlEntidad=new ControlEntidad('usuario');
  $objUsuario=$objControlEntidad->consultar($sql,[$email,$contrasena]);
  if($objUsuario){
    $_SESSION['email']=$email;
    //$datosUsuario = ['email' => $email, 'contrasena' => $contrasena];
		//$objUsuario = new Entidad($datosUsuario);
    $objControlRolUsuario = new ControlEntidad('rol_usuario');
    $sql = "SELECT rol.id as id, rol.nombre as nombre
        FROM rol_usuario INNER JOIN rol ON rol_usuario.fkidrol = rol.id
        WHERE fkemail = ?";
    $parametros = [$email];
    $listaRolesDelUsuario = $objControlRolUsuario->consultar($sql, $parametros);
    $_SESSION['listaRolesDelUsuario']=$listaRolesDelUsuario;
    //var_dump($listaRolesDelUsuario);
    header('Location: ./vista/menu.php');
  }
  else header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bootstrap 5 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
      .bg-image-vertical {
position: relative;
overflow: hidden;
background-repeat: no-repeat;
background-position: right center;
background-size: auto 100%;
}

@media (min-width: 1025px) {
.h-custom-2 {
height: 75%;
}
}
  </style>
  </head>
  <body>
  <section class="vh-100">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6 text-black">

        <div class="px-5 ms-xl-4">
          <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
          <span class="h1 fw-bold mb-0">Logo</span>
        </div>

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

          <form method="post" style="width: 23rem;">

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="email" id="txtEmail" name="txtEmail" class="form-control form-control-lg" />
              <label class="form-label" for="txtEmail">Email address</label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <input type="password" id="txtContrasena" name="txtContrasena" class="form-control form-control-lg" />
              <label class="form-label" for="txtContrasena">Password</label>
            </div>

            <div class="pt-1 mb-4">
              <input type="submit" class="btn btn-info btn-lg btn-block" id="btnLogin" name="btnLogin" value="Login">
              <!--<button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block" type="submit"
              id="btnLogin" name="btnLogin">Login</button>-->
            </div>

          </form>

        </div>

      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img3.webp"
          alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
      </div>
    </div>
  </div>
</section>
<!--FOOTER -->
<footer class="bg-body-tertiary text-center">
  <!-- Grid container -->
  <div class="container p-4 pb-0">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <a
      data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #3b5998;"
        href="https://www.facebook.com/ITMinstitucional"
        role="button"
        ><i class="fab fa-facebook-f"></i
      ></a>

      <!-- Twitter -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #55acee;"
        href="#!"
        role="button"
        ><i class="fab fa-twitter"></i
      ></a>

      <!-- Google -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #dd4b39;"
        href="https://www.itm.edu.co/"
        role="button"
        ><i class="fab fa-google"></i
      ></a>

      <!-- Instagram -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #ac2bac;"
        href="https://www.instagram.com/itminstitucional/"
        role="button"
        ><i class="fab fa-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #0082ca;"
        href="https://www.linkedin.com/school/institucion-universitaria-itm/posts/?feedView=all"
        role="button"
        ><i class="fab fa-linkedin-in"></i
      ></a>
      <!-- Github -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #333333;"
        href="https://github.com/cgomezre/ProyectoIndicadores.git"
        role="button"
        ><i class="fab fa-github"></i
      ></a>
    </section>
    <!-- Section: Social media -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2025 Copyright:
    <a class="text-body" href="https://www.itm.edu.co//">itm.edu.com</a>
  </div>
  <!-- Copyright -->
</footer>
  </body>
</html>
<?php
  ob_end_flush();
?>