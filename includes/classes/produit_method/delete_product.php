<?php
include_once("../Database.php");
include_once("../Produit.php");

$database = new Database();
$db = $database->getConnection();
$produit = new Produit($db);

$produit->id_produit = htmlspecialchars(trim($_POST["product_id"]));
echo "POST: ".$_POST["product_id"];
echo "id: ".$produit->id_produit;

if (!empty($_POST['product_id'])) {
    if ($produit->delete()) {
        header("Location: ../../../pages/produit.php");
    } else {
        echo "Erreur lors de la supression du produit";
    }
  }
?>