<?php
include_once("../includes/classes/Database.php");

$database = new Database();
$db = $database->getConnection();

$codeTournee = $_GET['code'];

// Récupérer les statuts des visites associées à la tournée
$query = "SELECT statut FROM visites WHERE code_tournee = :codeTournee";
$stmt = $db->prepare($query);
$stmt->bindParam(':codeTournee', $codeTournee);
$stmt->execute();
$visites = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si toutes les visites ont un statut de 1
$allValid = true;
foreach ($visites as $visite) {
    if ($visite['statut'] != 1) {
        $allValid = false;
        break;
    }
}

// Retourner le résultat
echo json_encode(['allValid' => $allValid]);
?>