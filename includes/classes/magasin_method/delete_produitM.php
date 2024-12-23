<?php
include_once("../Database.php");
include_once("../Magasin.php");

$database = new Database();
$db = $database->getConnection();
$magasin = new Magasin($db);
echo "hello";
$id_produit = htmlspecialchars(trim($_POST["product_id"]));
echo "hello1";
echo "<pre>";
    var_dump($_POST);
echo "</pre>";
var_dump($id_produit);
if (!empty($_POST['product_id'])) {
    if ($magasin->deleteProduit($id_produit)) {
        header("Location: ../../../pages/magasin.php");
    } else {
        echo "Erreur lors de la supression du produit";
    }
  }
?>