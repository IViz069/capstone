<?php

session_start();

if (isset($_SESSION['admin_id'])) {
  header('location:loginadmin.php');
}
require 'database.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM caps_admin WHERE email = '$email' AND password = '$password'";

  $records = $conn->prepare($sql);

  $records->execute();

  $results = $records->fetch(PDO::FETCH_ASSOC);

  $message = '';

  if (!($results == null) && $_POST['password'] == $results['password']) {
    $_SESSION['admin_id'] = $results['id'];
    $_SESSION['admin_email'] = $results['email'];
    header('location:admin.php');
  } else {
    $message = 'Crendenciales incorrectas';
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login administracion</title>
</head>
<body>
    <h1>Login de administracion</h1>
    <?php if (!empty($message)) : ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    <form action="loginadmin.php" method="POST">
        <input type="text" name="email" type="email" placeholder="Ingrese su correo">
        <input type="text" name="password" type="password" placeholder="Ingrese su contraseña">
        <input type="submit" value="Ingresar">
    </form>
</body>
</html>