<?php
    require 'database.php';
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('location:login.php');
    }else{
        $id = htmlspecialchars($_GET["id"]);
        $cant = $_POST['cant'];

        $sql = "INSERT INTO `caps_cart` (`id_cliente`, `id_item`, `cantidad`) VALUES ('3', ' $id ', '$cant');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        header('location:cart.php');
    }

?>