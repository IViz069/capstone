<?php

require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "INSERT INTO `caps_users` (`id`, `email`, `password`) VALUES (NULL, '$email', '$password')";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $_POST['email']);
  $stmt->bindParam(':password', $_POST['password']);

  if ($stmt->execute()) {
    $message = 'Se registro correctamente. <a href="login.php">Ingrese</a>';
  } else {
    $message = 'El correo ingresado ya esta en uso';
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Registrarse</title>
  <link rel="stylesheet" href="css/logincss.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


</head>

<body>
  <script>
    var check = function() {
      if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
        document.getElementById('butt').disabled = false;
        document.getElementById('butt').style.backgroundColor = 'green';
        document.getElementById('message').innerHTML = '';
      } else {
        document.getElementById('butt').disabled = true;
        document.getElementById('butt').style.backgroundColor = 'red';
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'Contraseñas no coinciden';
      }
    }
  </script>

  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://img.freepik.com/vector-gratis/ilustracion-concepto-sesion-movil_114360-135.jpg?w=2000" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <p id="message"></p>
          <form action="signup.php" method="POST">

            <!-- Email input -->
            <div class="form-outline mb-3">
              <input required="required" name="email" type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Ingrese su correo" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <input required="required" onkeyup='check();' minlength="7" name="password" type="password" id="password" class="form-control form-control-lg" placeholder="Ingrese su contraseña" />
            </div>

            <div class="form-outline mb-3">
              <input required="required" onkeyup='check();' minlength="7" name="confirm_password" type="password" id="confirm_password" class="form-control form-control-lg" placeholder="Confirme su contraseña" />
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <input id="butt" type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" value="Registrarse">
              <p class="small fw-bold mt-2 pt-1 mb-0">Tiene cuenta? <a href="signup.php" class="link-danger">Ingrese</a></p>
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