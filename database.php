<?php
try {
    $conn = new PDO('mysql:host=localhost:3306;dbname=capss', 'root', '');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
