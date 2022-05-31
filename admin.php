<?php
session_start();

require 'database.php';

if (isset($_SESSION['admin_id'])) {
   $records = $conn->prepare('SELECT id, email, password FROM caps_admin WHERE id = '. $_SESSION['admin_id']);
   $records->execute();
   $results = $records->fetch(PDO::FETCH_ASSOC);

   $user = null;

   if (count($results) > 0) {
      $user = $results;
   }

   
}
else{
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

</head>
<body>
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Productos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Trabajadores</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Categorias</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Ventas</a>
        </li>
        <?php if (!empty($user)) : ?>
            <li class="nav-item">
                <img width="40" src="images/profile.png">
                <a href="logout.php">Cerrar sesion</a>
            </li>
        <?php endif; ?>
        
    </ul>
</body>
</html>