<?php
    include_once("../Database.php");
    include_once("../Produit.php");

    $database = new Database();
    $db = $database->getConnection();
    $produit = new Produit($db);

    

?>