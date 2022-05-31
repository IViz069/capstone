<?php


require 'database.php';
require "funcs.php";

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
}
$cart = $conn->prepare('SELECT COUNT(*) AS CANT FROM caps_cart WHERE id_cliente = ' . $_SESSION['user_id']);
$cart->execute();
$cartResults = $cart->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <h1>Carrito</h1>
    <?php
    if ($cartResults['CANT'] == 0) {
        echo "Su carrito esta vacio";
    } else {
        $total = 0;
    ?>
        <table>
            <tr>
                <th>Producto</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th></th>
            </tr>

            <?php

            $cart2 = $conn->prepare('SELECT b.imagen, a.id_item, b.nombre, b.precio, a.cantidad FROM caps_cart a INNER JOIN caps_products b ON a.id_item = b.id WHERE a.id_cliente = ' . $_SESSION['user_id']);
            $cart2->execute();
            $cartResults2 = $cart2->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($cartResults2); $i++) {
                
            ?>

                <tr>
                    <td> <img width="100px" src="<?php echo $cartResults2[$i]['imagen'] ?>"> </td>
                    <td><?php echo $cartResults2[$i]['nombre'] ?></td>
                    <td><?php echo $cartResults2[$i]['precio'] ?></td>
                    <td><?php echo $cartResults2[$i]['cantidad'] ?></td>
                    <td><?php echo $cartResults2[$i]['precio'] * $cartResults2[$i]['cantidad'] ?></td>
                    <td><a href="removeitem.php?id=<?php echo $cartResults2[$i]['id_item'] ?>"><button>Eliminar del carro</button></a></td>
                </tr>



            <?php
            }

            //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
            ?>
        </table>
        <h1>IGV: <?php echo calcularPrecioTotal()*0.18 ?></h1>
        <h1>Precio total: <?php echo calcularPrecioTotal() + calcularPrecioTotal()*0.18 ?></h1>
        <a href="comprar.php"><button>Pagar</button></a>

    <?php
    }
    ?>
    <br>
    <a href="products.php">Seguir comprando</a>
</body>

</html>