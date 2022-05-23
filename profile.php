<?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
  }

  //require 'database.php';

  /*if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM caps_login WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Perfil</title>
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://rawgit.com/LeshikJanz/libraries/master/Bootstrap/baguetteBox.min.css">
</head>
<body>

    <?php
        echo $_SESSION['user_id'];

    ?>
    <a href="logout.php">Cerrar Sesion</a>
</body>
</html>