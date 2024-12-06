<?php
echo"Hello0";
include_once("../Database.php");
include_once("../Magasin.php");
echo"Hello1";
$database = new Database();
$db = $database->getConnection();
echo"Hello2";
$magasin = new Magasin($db);

// ID du magasin (par exemple, passé via un champ caché dans le formulaire ou l'URL)
$magasin->id_magasin = isset($_POST['id_magasin']) ? intval($_POST['id_magasin']) : null;
echo"Hello3";
// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si des produits ont été sélectionnés
    echo"Hello4";
    echo"<pre>";
    var_dump($_POST);
    echo"</pre>";
    if (!empty($_POST['products'])) {
        $products = $_POST['products']; // Tableau des ID des produits cochés
        echo"Hello5";
        // Ajouter chaque produit au magasin
        foreach ($products as $productId) {
            echo"Hello6";
            if ($magasin->addProduit(intval($productId))) {
                echo "Produit (ID: " . htmlspecialchars($productId) . ") ajouté au magasin.<br>";
            } else {
                echo "Erreur lors de l'ajout du produit (ID: " . htmlspecialchars($productId) . ").<br>";
            }
        }
    } else {
        echo "Aucun produit sélectionné.";
    }
}

// Récupérer les produits liés au magasin
$produitsAssocies = $magasin->getProduit();

// Afficher les produits associés
if (!empty($produitsAssocies)) {
    echo "<h3>Produits associés au magasin :</h3>";
    echo "<ul>";
    foreach ($produitsAssocies as $produit) {
        echo "<li>" . htmlspecialchars($produit['nom_commercial']) . " (Quantité : " . htmlspecialchars($produit['quantite']) . ", Dernière livraison : " . htmlspecialchars($produit['date_ajout']) . ")</li>";
    }
    echo "</ul>";
} else {
    echo "Aucun produit associé à ce magasin.";
}
?>
