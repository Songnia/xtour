<?php
// export_csv.php

// Inclure les fichiers nécessaires (comme Database.php, Magasin.php, etc.)
include_once("Database.php");
include_once("Magasin.php");
include_once("Produit.php");

// Initialiser la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupérer les résultats (remplace cela par ta logique pour récupérer $results)
$query = "
    SELECT 
        v.id_visite,
        v.codeTournee,
        v.magasin_id,
        v.ville,
        v.date_visite,
        v.feedback,
        v.feedback_value,
        v.feedback_description,
        sp.id_stock,
        sp.produit_id,
        sp.date_fabrication,
        sp.date_expiration,
        sp.etat AS stock_etat,
        sp.quantite_rayon,
        sp.quantite_stock,
        sp.qts_rayon,
        sp.qts_stock,
        sp.image_path,
        rv.id_reponse,
        rv.etiquette,
        rv.presence_promotrice,
        rv.existance_promotrice,
        rv.emplacement,
        rv.visibilite_produit,
        rv.prix_etiquette,
        m.groupe
    FROM 
        Visite v
    LEFT JOIN 
        stocks_produits sp ON v.id_visite = sp.visite_id
    LEFT JOIN 
        reponses_verification rv ON v.id_visite = rv.visite_id
    LEFT JOIN 
        Magasin m ON m.id_magasin = v.magasin_id;
    "; 

    

$stmt = $db->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
//var_dump($results);
echo "</pre>";
// Vérifier s'il y a des données à exporter
if (!empty($results)) {
    // Définir le nom du fichier CSV
    $filename = "rapport_tournees_" . date('Y-m-d') . ".csv";

    // Envoyer les en-têtes pour forcer le téléchargement du fichier
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Ouvrir un flux de sortie pour écrire le fichier CSV
    $output = fopen('php://output', 'w');

    // Écrire l'en-tête du CSV (les noms des colonnes)
    $header = array_keys($results[0]); // Prend les clés du premier élément comme en-tête
    fputcsv($output, $header);

    // Écrire les données dans le fichier CSV
    foreach ($results as $row) {
        fputcsv($output, $row);
    }

    // Fermer le flux de sortie
    fclose($output);
    exit; // Arrêter l'exécution du script après avoir généré le CSV
} else {
    //echo "Aucune donnée à exporter.";
}
header("Location: ../../pages/rapport.php");
?>