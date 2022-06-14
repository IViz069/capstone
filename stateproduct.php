<?php
    session_start();

    require 'database.php';

    $id = htmlspecialchars($_GET["id"]);

    $products = $conn->prepare("SELECT * FROM caps_products WHERE id = $id;");
    $products->execute();
    $productsResults = $products->fetch(PDO::FETCH_ASSOC);

    if($productsResults['disabled']==1){
        $products = $conn->prepare("UPDATE `caps_products` SET `disabled`= 0 WHERE id = $id;");
        $products->execute();
        
    }
    else{
        $products = $conn->prepare("UPDATE `caps_products` SET `disabled`= 1 WHERE id = $id;");
        $products->execute();
    }

    header('location:productsadm.php');
?>