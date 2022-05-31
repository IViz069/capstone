<?php
    require 'database.php';
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('location:login.php');
    }else{
        $id = htmlspecialchars($_GET["id"]);
        $cant = $_POST['cant'];
        $user = $_SESSION['user_id'];

        $sql = "INSERT INTO `caps_cart` (`id_cliente`, `id_item`, `cantidad`) VALUES ('$user', ' $id ', '$cant');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        header('location:cart.php');
    }

?>