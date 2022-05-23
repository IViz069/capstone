<?php

session_start();

if (isset($_SESSION['user_id'])) {
  header('location:index.php');
}
require 'database.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM caps_users WHERE email = '$email' AND password = '$password'";

  $records = $conn->prepare($sql);

  $records->bindParam(':email', $_POST['email']);

  $records->execute();

  $results = $records->fetch(PDO::FETCH_ASSOC);

  $message = '';

  if (!($results == null) && $_POST['password'] == $results['password']) {
    $_SESSION['user_id'] = $results['id'];
    header('location:index.php');
  } else {
    $message = 'Crendenciales incorrectas';
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Ingresar</title>
  <link rel="stylesheet" href="css/logincss.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>


  <br>

  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://img.freepik.com/vector-gratis/ilustracion-concepto-sesion-movil_114360-135.jpg?w=2000" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <form action="login.php" method="POST">

            <!-- Email input -->
            <div class="form-outline mb-4">
              <input name="email" type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Ingrese su correo" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input name="password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Ingrese su contraseña" />
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <input type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" value="Ingresar">
              <p class="small fw-bold mt-2 pt-1 mb-0">No tiene cuenta? <a href="signup.php" class="link-danger">Registrese</a></p>
            </div>

          </form>
          <?php if (!empty($message)) : ?>
            <p> <?= $message ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
      <!-- Copyright -->
      <div class="text-white mb-3 mb-md-0">
        Copyright © 2022. Rodamientos salas SRL derechos reservados.
        <a style="color: black;" href="#">Login administrativo</a>
      </div>
      <!-- Copyright -->
      <div>
      <a href="index.php" class="text-white me-4">Inicio</a>
    </div>
    </div>
  </section>
</body>

</html>