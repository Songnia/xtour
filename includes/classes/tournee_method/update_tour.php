<?php
include_once("../Database.php"); 
include_once("../Tournee.php");

$database = new Database();
$db = $database->getConnection();
$tour = new Tour($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assainir et valider les données entrantes
    $id_tour = htmlspecialchars(trim($_POST['id_tour']));
    $objectif = htmlspecialchars(trim(string: $_POST['remarque']));
    echo "<pre>";
    var_dump($_POST);  // Affiche les données envoyées par le formulaire
    echo "</pre>";
    // Vérifier si les champs sont remplis correctement
    if (empty($id_tour) || empty($objectif)) {
        echo "Tous les champs sont obligatoires.";
        return;
    }

    // Affecter les valeurs aux propriétés de l'objet Tour
    $tour->id_tour = $id_tour;  // Code statique ou peut être dynamique selon le besoin
    $tour->objectif = $objectif;
    // Debugging - affichage des données reçues
    echo "<pre>";
    var_dump($_POST);  // Affiche les données envoyées par le formulaire
    echo "</pre>";

    echo "<pre>";
    var_dump($tour);  // Affiche l'objet Tour avec ses propriétés
    echo "</pre>";

    if( $tour->updateObjectif()){
        echo "Remarque ajouter avec succès";
        header("Location: ../../../pages/tournee-res-com.php");
    } else {
        echo "Une erreur s'est produite lors de l'ajout du magasin.";
    }
}
?>
