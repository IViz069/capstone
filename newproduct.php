<?php
session_start();

require 'database.php';

$brands = $conn->prepare('SELECT id, name FROM caps_brands');
$brands->execute();
$brandsResults = $brands->fetchAll(PDO::FETCH_ASSOC);

$categories = $conn->prepare('SELECT * FROM caps_categories');
$categories->execute();
$categoriesResults = $categories->fetchAll(PDO::FETCH_ASSOC);

$nume = $conn->prepare('SELECT `AUTO_INCREMENT` AS NUME FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "capss" AND   TABLE_NAME   = "caps_products";');
$nume->execute();
$numeRes = $nume->fetchAll(PDO::FETCH_ASSOC);
$numb = $numeRes[0]['NUME'];

if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['stock']) && !empty($_POST['image']) && !empty($_POST['descrip']) && !empty($_POST['bran']) && !empty($_POST['cate'])) {
    $array = array($_POST['name'], $_POST['price'], $_POST['stock'], $_POST['image'], $_POST['descrip'], $_POST['bran'], $_POST['cate']);

    $insertPro = $conn->prepare("INSERT INTO `caps_products` (`id`, `nombre`, `precio`, `cantidad`, `imagen`, `descr`, `id_brand`, `disabled`, `stats`) VALUES (NULL, '$array[0]', '$array[1]', '$array[2]', '$array[3]', '$array[4]', '$array[5]', '0', '0');");
    $insertPro->execute();

    for ($i=0; $i <count($_POST['cate']) ; $i++) {
        $idCate = $_POST['cate'][$i];
        $insertCate = $conn->prepare("INSERT INTO `caps_productxcategorie` (`id_product`, `id_categorie`) VALUES ('$numb', '$idCate');");
        $insertCate->execute();
    }

    header('location:productsadm.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar producto</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lumen/bootstrap.min.css">
</head>

<body>

    <div class="container-md">
        <br>
        <h2 class="text-primary">Agregando nuevo producto</h2>
        <a href="http://localhost/caps/productsadm.php">Cancelar</a>
        <br>
        <form action="newproduct.php" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label mt-4">Nombre</label>
                <input type="text" class="form-control" name="name" placeholder="Ingrese el nuevo nombre del producto">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Precio</label>
                <input type="number" step="0.1" class="form-control" name="price" placeholder="Ingrese el nuevo precio del producto">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Stock</label>
                <input type="number" class="form-control" name="stock" placeholder="Ingrese el nuevo stock del producto">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Imagen</label>
                <input type="text" class="form-control" name="image" placeholder="Ingrese la nueva imagen del producto">
            </div>
            <div class="form-group">
                <label for="exampleSelect1" class="form-label mt-4">Marca</label>
                <select class="form-select" name="bran">
                    <option value="" selected disabled hidden>Seleccione la marca</option>
                    <?php
                    for ($i = 0; $i < count($brandsResults); $i++) {
                        echo '<option value = ' . $brandsResults[$i]['id'] . '>' . $brandsResults[$i]['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <fieldset class="form-group">
                <legend class="mt-4">Seleccione categorias</legend>
                <?php
                    for ($i = 0; $i < count($categoriesResults); $i++) {
                        echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="' . $categoriesResults[$i]['id'] . '" name="cate[]">
                        <label class="form-check-label" for="flexCheckDefault">
                          '. $categoriesResults[$i]['descr'] .'
                        </label>
                      </div>';
                    }
                    ?>
                
            </fieldset>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Descripcion</label>
                <textarea name="descrip" cols="30" rows="3" type="text" class="form-control" placeholder="Ingrese la nueva Descripcion del producto"></textarea>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Guardar producto">
            </div>

        </form>
    </div>
    <br>
</body>

</html>