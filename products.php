<?php
session_start();

require 'database.php';

$products = $conn->prepare('SELECT * FROM caps_products WHERE disabled = 0');
$products->execute();
$productsResults = $products->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lumen/bootstrap.min.css">

</head>

<body>

    <h1 align="center">Nuestros productos</h1>
    <br>
    <div class="d-flex justify-content-center">

        <form class="row g-3" method="GET">
            <div class="col-auto">
                <p class="form-control-plaintext" disabled>Buscar producto:</p>
            </div>
            <div class="col-auto">
                <label for="inputPassword2" class="visually-hidden">Password</label>
                <input name="n" type="text" class="form-control" id="inputPassword2" placeholder="Nombre del producto">
            </div>
            <div class="col-auto">
                <p class="form-control-plaintext" disabled>Categoria:</p>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <select class="form-select" id="exampleSelect1">
                        <option>Goma</option>
                        <option></option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Buscar</button>
            </div>

        </form>


    </div>
    <br>
    <div class="container-md" align="center">

        <?php
        for ($i = 0; $i < count($productsResults); $i++) {
        ?>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $productsResults[$i][4] ?>" alt="..." class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $productsResults[$i][1] ?></h5>
                            <p class="card-text">Precio: S/<?php echo $productsResults[$i][2] ?></p>
                            <a href="item.php?id=<?php echo $productsResults[$i][0] ?>"><button class="btn btn-primary"> Ver</button></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php

        }
        ?>
    </div>

</body>

</html>