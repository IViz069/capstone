<?php
    session_start();

    require 'database.php';

    $id =htmlspecialchars($_GET["id"]);
    $products = $conn->prepare('SELECT * FROM caps_products WHERE id='.$id);
    $products->execute();
    $productsResults = $products->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['stock']) && !empty($_POST['image']) && !empty($_POST['descrip']) ){
        $array = array($_POST['name'],$_POST['price'],$_POST['stock'],$_POST['image'],$_POST['descrip']);
        echo print_r($array);
        $updatePro = $conn->prepare("UPDATE caps_products SET nombre='$array[0]', precio=$array[1], cantidad=$array[2], imagen='$array[3]', descr='$array[4]' WHERE id = $id");
        $updatePro->execute();
        header('location:productsadm.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lumen/bootstrap.min.css">
</head>

<body>
    
    <div class="container-md">
        <br>
        <h2 class="text-primary">Editando <?php echo $productsResults['nombre'] ?></h2>
        <a href="http://localhost/caps/productsadm.php">Cancelar</a>
        <br>
        <form action="editproduct.php?id=<?php echo $id ?>" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label mt-4">Nombre</label>
                <input value="<?php echo $productsResults['nombre'] ?>" type="text" class="form-control" name="name" placeholder="Ingrese el nuevo nombre del producto">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Precio</label>
                <input value="<?php echo $productsResults['precio'] ?>" type="number" step="0.1" class="form-control" name="price" placeholder="Ingrese el nuevo precio del producto">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Stock</label>
                <input value="<?php echo $productsResults['cantidad'] ?>" type="number" class="form-control" name="stock" placeholder="Ingrese el nuevo stock del producto">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Imagen</label>
                <input value="<?php echo $productsResults['imagen'] ?>" type="text" class="form-control" name="image" placeholder="Ingrese la nueva imagen del producto">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Descripcion</label>
                <textarea name="descrip" cols="30" rows="3" type="text" class="form-control" placeholder="Ingrese la nueva Descripcion del producto"><?php echo $productsResults['descr'] ?></textarea>
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