<?php
session_start();

require 'database.php';

if (isset($_SESSION['admin_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM caps_admin WHERE id = ' . $_SESSION['admin_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;
    $message="";
    if (count($results) > 0) {
        $user = $results;
        $query = "SELECT id, nombre, cantidad, precio, imagen, stats,
        CASE
             WHEN disabled=0 THEN 'No'
             ELSE 'Sí'
        END AS Deshabilitado
    FROM caps_products;";
        if (isset($_GET['name'])) {
            $name = $_GET['name'];
            $message = 'value='. $_GET['name'];
            $query = "SELECT id, nombre, cantidad, precio, imagen, stats,
            CASE
                 WHEN disabled=0 THEN 'No'
                 ELSE 'Sí'
            END AS Deshabilitado
        FROM caps_products
        WHERE nombre LIKE '%$name%';";
            $products = $conn->prepare($query);
            $products->execute();
            $productsResults = $products->fetchAll();
        } else {
            $products = $conn->prepare($query);
            $products->execute();
            $productsResults = $products->fetchAll();
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
                        <a class="nav-link active" href="productsadm.php">Productos</a>
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
    <br>

    <div class="container-md">
        <div class="row g-3">
            <div class="col-auto">
                <form class="row g-3" method="GET">
                    <div class="col-auto">
                        <p class="form-control-plaintext" disabled>Buscar producto:</p>
                    </div>
                    <div class="col-auto">
                        <label for="inputPassword2" class="visually-hidden">Password</label>
                        <input <?php echo $message?> name="name" required type="text" class="form-control" id="inputPassword2" placeholder="Nombre del producto">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Buscar</button>
                    </div>
                </form>
            </div>
            <div class="col-auto">
                <a href="newproduct.php"><button type="submit" class="btn btn-success mb-3">Agregar producto</button></a>
            </div>
            
        </div>
        
        
        <table class="table table-hover table-striped table-info">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Ventas</th>
                    <th scope="col">Deshabilitado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tr>
                <?php
                for ($i = 0; $i < count($productsResults); $i++) {
                ?>
            <tr>
                <td><?php echo $productsResults[$i]['id'] ?></td>
                <td><img src="<?php echo $productsResults[$i]['imagen'] ?>" alt="" width="100"></td>
                <td><?php echo $productsResults[$i]['nombre'] ?></td>
                <td><?php echo $productsResults[$i]['precio'] ?></td>
                <td><?php echo $productsResults[$i]['cantidad'] ?></td>
                <td><?php echo $productsResults[$i]['stats'] ?></td>
                
                <td><?php echo $productsResults[$i]['Deshabilitado'] ?></td>
                <td>
                    <a href="editproduct.php?id=<?php echo $productsResults[$i]['id'] ?>"><button class="btn btn-warning">Editar</button></a>
                    <?php
                        if($productsResults[$i]['Deshabilitado']=="Sí"){
                            ?> 
                            <a href="stateproduct.php?id=<?php echo $productsResults[$i]['id'] ?>"><button class="btn btn-success" onclick="return confirm('Estas seguro?, los clientes veran el producto')">Habilitar</button></a>
                            <?php
                        }else{
                            ?> 
                            <a href="stateproduct.php?id=<?php echo $productsResults[$i]['id'] ?>"><button class="btn btn-danger" onclick="return confirm('Estas seguro?, los clientes no veran el producto')">Deshabilitar</button></a>
                            <?php
                        }
                        
                    ?>
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