<?php
session_start();

require 'database.php';

$categories = $conn->prepare('SELECT * FROM caps_categories');
$categories->execute();
$categoriesResults = $categories->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['n']) && isset($_GET['c'])) {
    $name = $_GET['n'];
    $cat = $_GET['c'];
    $query = "SELECT a.*, c.descr FROM caps_products a INNER JOIN caps_productxcategorie b ON a.id=b.id_product INNER JOIN caps_categories c ON b.id_categorie = c.id WHERE disabled = 0 AND c.id = $cat AND nombre LIKE '%$name%';";
    $products = $conn->prepare($query);
    $products->execute();
    $productsResults = $products->fetchAll();
}
else if (isset($_GET['n'])){
    $name = $_GET['n'];
    $query = "SELECT * FROM caps_products WHERE disabled = 0 AND nombre LIKE '%$name%';";
    $products = $conn->prepare($query);
    $products->execute();
    $productsResults = $products->fetchAll();
}
else if (isset($_GET['c']) && $_GET['n']==""){
    $cat = $_GET['c'];
    $query = "SELECT a.*  FROM caps_products a INNER JOIN caps_productxcategorie b ON a.id=b.id_product WHERE disabled = 0 AND b.id_categorie=$cat AND nombre LIKE '%%';";
    $products = $conn->prepare($query);
    $products->execute();
    $productsResults = $products->fetchAll();
}
else{
    $products = $conn->prepare('SELECT * FROM caps_products WHERE disabled = 0');
    $products->execute();
    $productsResults = $products->fetchAll();
}

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
                    <select class="form-select" name="c">
                    <option value="" selected disabled hidden>Categoria</option>
                        <?php
                            for ($i=0; $i < count($categoriesResults); $i++) { 
                                echo '<option value = '.$categoriesResults[$i]['id'].'>' . $categoriesResults[$i]['descr'] . '</option>';
                            }
                        ?>
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
        if($productsResults == null){
            echo '<h1>No se encontraron productos</h1>';
            return;
        }
        
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