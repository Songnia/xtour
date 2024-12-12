<?php

include_once("../Database.php");
include_once("../Magasin.php");
include_once("../Produit.php");

$database = new Database();
$db = $database->getConnection();

$magasin = new Magasin($db);
$produit = new Produit($bd);

// ID du magasin (par exemple, passé via un champ caché dans le formulaire ou l'URL)
$magasin->id_magasin = isset($_POST['id_magasin']) ? intval($_POST['id_magasin']) : null;
try{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['products'])) {
        $products = $_POST['products']; // Tableau des ID des produits cochés
        //Recuperer l'id du produit dans la table produit
        foreach ($products as $prod):
            $query = "SELECT id_produit FROM Produit WHERE nom_commercial=:Nom";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":Nom",$prod,PDO::PARAM_STR);
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            // Vérifier si un produit a été trouvé
            if (isset($result['id_produit'])) {
                // Appel de la méthode addProduit
                if ($magasin->addProduit($prod, $result['id_produit'])){
                        header("Location: ../../../pages/magasin.php");
                    }
            } else {
                echo "Produit non trouvé dans la base de données : " . htmlspecialchars($prod) . "<br>";
            }

        endforeach;
    }else {
        echo "Aucun produit sélectionné.";
    }
}
}catch (Exception $e) {
    // Annuler la transaction en cas d'erreur
    error_log($e->getMessage());
    echo "Erreur capturée : " . $e->getMessage();
    return false;
}
