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
        if (isset($_GET['name'])) {
            $name = $_GET['name'];
            $people = $conn->prepare("SELECT * FROM caps_admin WHERE name LIKE '%$name%';");

            $people->execute();
            $peopleResults = $people->fetchAll();
        } else {
            $people = $conn->prepare('SELECT * FROM caps_admin');
            $people->execute();
            $peopleResults = $people->fetchAll();
        }
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
                        <a class="nav-link " href="admin.php">Inicio
                            <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="productsadm.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="empleadmin.php">Trabajadores</a>
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
    <br>

    <div class="container-md">
        <form class="row g-3" method="GET">
            <div class="col-auto">
                <p class="form-control-plaintext" disabled>Buscar empleado:</p>
            </div>
            <div class="col-auto">
                <label for="inputPassword2" class="visually-hidden">Password</label>
                <input name="name" type="text" class="form-control" id="inputPassword2" placeholder="Nombre del empleado">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Buscar</button>
            </div>
        </form>

        <table class="table table-hover table-striped table-info">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tr>
                <?php
                for ($i = 0; $i < count($peopleResults); $i++) {
                ?>
            <tr>
                <td><?php echo $peopleResults[$i]['id'] ?></td>
                <td><?php echo $peopleResults[$i]['name'] ?></td>
                <td><?php echo $peopleResults[$i]['surname'] ?></td>
                <td><?php echo $peopleResults[$i]['email'] ?></td>
                <td>
                    <a href="#?id=<?php echo $peopleResults[$i]['id'] ?>"><button class="btn btn-warning">Editar</button></a>
                    <a href="#?id=<?php echo $peopleResults[$i]['id'] ?>"><button class="btn btn-danger">Deshabilitar</button></a>
                </td>
            </tr>
        <?php
                }
        ?>
        </tr>
        </table>
    </div>

</body>

</html>