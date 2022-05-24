<?php
session_start();



function calcularPrecioTotal()
{
    require 'database.php';
    $cart2 = $conn->prepare('SELECT b.precio, a.cantidad FROM caps_cart a INNER JOIN caps_products b ON a.id_item = b.id WHERE a.id_cliente = ' . $_SESSION['user_id']);
    $cart2->execute();
    $cartResults2 = $cart2->fetchAll(PDO::FETCH_ASSOC);

    $total = 0;
    
    for ($i = 0; $i < count($cartResults2); $i++) {
        
        $total = $total + $cartResults2[$i]['precio'] * $cartResults2[$i]['cantidad'];

    }
    
    return $total;
}
?>