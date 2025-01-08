<?php
include_once("../Database.php"); 
include_once("../Tournee.php");

$database = new Database();
$db = $database->getConnection();
$tour = new Tour($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assainir et valider les données entrantes
    $code_tournee = htmlspecialchars(trim($_POST['code_tournee2']));
    
    echo "<pre>";
    var_dump($_POST);  // Affiche les données envoyées par le formulaire
    echo "</pre>";
    // Vérifier si les champs sont remplis correctement
    if (empty($code_tournee)) {
        echo "Tous les champs sont obligatoires.";
        return;
    }

    // Affecter les valeurs aux propriétés de l'objet Tour
    $tour->code = $code_tournee;


    echo "<pre>";
    var_dump($tour);  // Affiche l'objet Tour avec ses propriétés
    echo "</pre>";

    if( $tour->updateTourneeStatus()){
        echo "tourner valider avec succès";
        header("Location: ../../../pages/tournee-res-com.php");
    } else {
        echo "Une erreur s'est produite lors de l'ajout du magasin.";
    }
}
?>
