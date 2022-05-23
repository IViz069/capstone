<?php
session_start();

require 'database.php';

$products = $conn->prepare('SELECT * FROM caps_products');
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
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <h1 align="center">Nuestros productos</h1>
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
                            <a href="item.php?id=<?php echo $productsResults[$i][0] ?>"><button class="btn btn-info"> Ver</button></a>
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