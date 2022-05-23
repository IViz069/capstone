<?php
session_start();



function calcularPrecioTotal()
{
    $total = 0;
    require 'database.php';
    for ($i = 0; $i < count($_SESSION['cart']) / 2; $i++) {
        $products = $conn->prepare('SELECT * FROM caps_products WHERE id=' . $_SESSION['cart'][$i * 2]);
        $products->execute();
        $productsResults = $products->fetch(PDO::FETCH_ASSOC);
        $total = $total + $productsResults['precio']*$_SESSION['cart'][($i * 2)+1];

    }
    
    return $total;
}
?>