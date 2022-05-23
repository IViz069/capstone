<?php
    session_start();

    require 'database.php';

    function hasItem(array $items, $value){
        for($i=0;$i<count($items);$i++){
            if($i%2==0){
                if($items[$i]== (int) $value){
                    return True;
                }
            }
        }
        return False;
    }

    $products = $conn->prepare('SELECT * FROM caps_products WHERE id='.htmlspecialchars($_GET["id"]));
    $products->execute();
    $productsResults = $products->fetch(PDO::FETCH_ASSOC);

    $checkItem = $conn->prepare('SELECT COUNT(*) AS CANT FROM caps_cart WHERE id_cliente=' . $_SESSION['user_id']. ' AND id_item = ' . htmlspecialchars($_GET["id"]));
    $checkItem->execute();
    $checkItemResults = $checkItem->fetch(PDO::FETCH_ASSOC);

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
                <span>#Marca#</span>
                <h1><?php echo  $productsResults['nombre']?></h1>
                <p>The preferred choice of a vast range of acclaimed DJs. Punchy, bass-focused sound and high isolation. Sturdy headband and on-ear cushions suitable for live performance</p>
            </div>

            <!-- Product Pricing -->
            <div class="product-price">
                <span>S/<?php echo  $productsResults['precio']?></span>
                <form method="POST" action="addcart.php?id=<?php echo  $productsResults['id']?>">
                    <input type="number" name="cant" value="1" min="1">
                    <?php

                        if($checkItemResults['CANT']>0){
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