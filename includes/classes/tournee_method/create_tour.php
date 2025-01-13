<?php
include_once("../Database.php"); 
include_once("../Tournee.php");
session_start();

$database = new Database();
$db = $database->getConnection();
$tour = new Tour($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assainir et valider les données entrantes
    $nom_magasin = htmlspecialchars(trim($_POST['nom_magasin']));
    $date = htmlspecialchars(trim($_POST['date']));
    $jour = htmlspecialchars(trim($_POST['jour']));
    $code_tournee = htmlspecialchars(trim($_POST['code_tournee']));
    $objectif = htmlspecialchars(trim(string: $_POST['remarque']));
    echo "<pre>";
    var_dump($_POST);  // Affiche les données envoyées par le formulaire
    echo "</pre>";
    // Vérifier si les champs sont remplis correctement
    if (empty($nom_magasin) || empty($date) || empty($jour)) {
        echo "Tous les champs sont obligatoires.";
        return;
    }

    // Affecter les valeurs aux propriétés de l'objet Tour
    $tour->nom_magasin = $nom_magasin;
    $tour->date = $date;
    $tour->jour = $jour;
    $tour->code = $code_tournee;  // Code statique ou peut être dynamique selon le besoin
    $tour->objectif = $objectif;
    // Debugging - affichage des données reçues
    echo "<pre>";
    var_dump($_POST);  // Affiche les données envoyées par le formulaire
    echo "</pre>";

    echo "<pre>";
    var_dump($tour);  // Affiche l'objet Tour avec ses propriétés
    echo "</pre>";

    if( $tour->create($tour->code)){
        echo "Le Magasin a été ajouter avec succès";
        switch($_SESSION['role']) {/*'Admin', 'Commercial', 'responsable_commercia...	*/
            case 'Admin': $location ="../../../pages/tournee-res-com.php"; ;
                break;
            case 'Commercial':$location ="../../../pages/tournee-com.php";;
                break;
            case 'responsable_commercial': $location ="../../../pages/tournee-res-com.php";;
                break;
        }
        header("Location:".$location);
    } else {
        echo "Une erreur s'est produite lors de l'ajout du magasin.";
    }
}
?>
