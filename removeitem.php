<?php
    session_start();

    require 'database.php';

    $cart2 = $conn->prepare('DELETE FROM `caps_cart` WHERE `caps_cart`.`id_cliente` = ' . $_SESSION['user_id'] . ' AND `caps_cart`.`id_item` = ' . htmlspecialchars($_GET["id"]));
    $cart2->execute();


    header('location:cart.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>