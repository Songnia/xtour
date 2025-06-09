<?php
include_once("../Database.php"); 
include_once("../Tournee.php");

// Définir le type de contenu comme JSON
header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();
$tour = new Tour($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assainir et valider les données entrantes
    $code_tournee = htmlspecialchars(trim($_POST['code']));
    $statut = htmlspecialchars(trim($_POST['statut']));

    // Vérifier si les champs sont remplis correctement
    if (empty($code_tournee)) {
        echo json_encode([
            'success' => false,
            'message' => 'Le code de tournée est obligatoire'
        ]);
        exit;
    }

    // Affecter les valeurs aux propriétés de l'objet Tour
    $tour->code = $code_tournee;

    if ($tour->updateTourneeStatus($statut)) {
        echo json_encode([
            'success' => true,
            'message' => 'Statut de la tournée mis à jour avec succès'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du statut'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
}
?>
