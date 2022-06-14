<?php
session_start();

require 'database.php';

if (isset($_SESSION['admin_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM caps_admin WHERE id = ' . $_SESSION['admin_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
        $user = $results;
    }
} else {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lumen/bootstrap.min.css">

</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.php">Inicio
                            <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productsadm.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="empleadmin.php">Trabajadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categorias</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <?php if (!empty($user)) : ?>
                        <li class="nav-item">
                            <img width="40" src="images/profile.png">
                            <a><?php echo $_SESSION['admin_email'] ?></a>
                            <a style="color: black;" href="logout.php">Cerrar sesion</a>
                        </li>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </nav>



</body>

</html>