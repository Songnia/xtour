<?php
include_once("../Database.php");
include_once("../Produit.php");

$database = new Database();
$db = $database->getConnection();
$produit = new Produit($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produit->nom_commercial = htmlspecialchars(trim($_POST["nom_commercial"]));
    $produit->nom_descriptif = htmlspecialchars(trim($_POST["nom_descriptif"]));
    $produit->prix = htmlspecialchars(trim($_POST["prix"]));
    $produit->poids = htmlspecialchars(trim($_POST["poids"]));

    // Vérifie si product_id est défini pour déterminer l'édition
    if (!empty($_POST['product_id'])) {
        $produit->id_produit = $_POST['product_id'];
        if ($produit->update()) {
            header("Location: ../../../pages/produit.php");
        } else {
            echo "Erreur lors de la mise à jour du produit";
        }
    } else {
        if ($produit->create()) {
            header("Location: ../../../pages/produit.php");
        } else {
            echo "Erreur lors de l'ajout du produit";
        }
    }
}
?>
