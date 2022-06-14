<?php
    session_start();

    require 'database.php';

    $products = $conn->prepare('SELECT a.id, a.nombre, a.precio, a.descr, a.imagen, b.name FROM caps_products a INNER JOIN caps_brands b ON a.id = b.id WHERE a.id='.htmlspecialchars($_GET["id"]) );
    $products->execute();
    $productsResults = $products->fetch(PDO::FETCH_ASSOC);

    if(isset($_SESSION['user_id'])){
        $checkItem = $conn->prepare('SELECT COUNT(*) AS CANT FROM caps_cart WHERE id_cliente=' . $_SESSION['user_id']. ' AND id_item = ' . htmlspecialchars($_GET["id"]));
        $checkItem->execute();
        $checkItemResults = $checkItem->fetch(PDO::FETCH_ASSOC);
    }

    if($productsResults==NULL){
        header('location:products.php');
    }
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylepro.css">
    <title><?php echo  $productsResults['nombre']?></title>
</head>

<body>
    <main class="container">

        <!-- Left Column / Headphones Image -->
        <div class="left-column">
            <img class="active" src="<?php echo  $productsResults['imagen']?>" alt="">

        </div>


        <!-- Right Column -->
        <div class="right-column">

            <!-- Product Description -->
            <div class="product-description">
                <span><?php echo  $productsResults['name']?></span>
                <h1><?php echo  $productsResults['nombre']?></h1>
                <p><?php echo  $productsResults['descr']?></p>
            </div>

            <!-- Product Pricing -->
            <div class="product-price">
                <span>S/<?php echo  $productsResults['precio']?></span>
                <form method="POST" action="addcart.php?id=<?php echo  $productsResults['id']?>">
                    <input type="number" name="cant" value="1" min="1">
                    <?php

                        if(isset($_SESSION['user_id']) && $checkItemResults['CANT']>0 ){
                            ?>
                            <input id="butt" type="submit" value="Producto ya en el carrito" disabled>
                            <?php
                        }
                        else{
                            ?>
                            <input id="butt" type="submit" value="Agregar al carrito" >
                            <?php
                        }
                    ?>
                    
                </form>
                
            </div>
        </div>
    </main>
    
</body>

</html>