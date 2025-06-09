<?php
session_start();
$id_utilisateur = $_SESSION['id_utilisateur'];
$role_utilisateur = $_SESSION['role'];

//echo $id_utilisateur ." ".$rode_utilisateur ;
echo "hello";
include_once("../Database.php"); 
include_once("../Tournee.php");
echo "hello2";

$database = new Database();
$db = $database->getConnection();
$tour = new Tour($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assainir et valider les données entrantes
    $type_quik = isset($_POST['is_quick_tour']) && $_POST['is_quick_tour'] !== '' ? intval($_POST['is_quick_tour']) : 1;
    $nom_magasin = htmlspecialchars(trim($_POST['nom_magasin']));
    $date = htmlspecialchars(trim($_POST['date']));
    //$jour = htmlspecialchars(string: trim($_POST['jour']));
    $ville = htmlspecialchars(trim($_POST['ville']));
    $objectif = trim($_POST['remarque']);
    $id_commercial = trim($_POST['id_commercial']);

    if($role_utilisateur === "responsable_commercial"){
        $id_utilisateur = $id_commercial;
    }

    echo "<pre>";
    //var_dump($_POST);  // Affiche les données envoyées par le formulaire
    echo "</pre>";

    // Vérifier si les champs sont remplis correctement
    if (empty($nom_magasin) || empty($date) || empty($ville)) {
        echo "Tous les champs sont obligatoires.";
        
        return;
    }

    $code_tournee = substr($ville,0,3) ."".rand(0,100);

    // Affecter les valeurs aux propriétés de l'objet Tour
    $tour->type = $type_quik ;
    $tour->nom_magasin = $nom_magasin;
    $tour->date = $date;
    $tour->jour = $jour;
    $tour->ville = $ville;
    $tour->code = $code_tournee;
    $tour->objectif = $objectif;

    // Debugging - affichage des données reçues
    echo "<pre>";
    //var_dump($_POST);  // Affiche les données envoyées par le formulaire
    echo "</pre>";

    echo "<pre>";
    //var_dump($tour);  // Affiche l'objet Tour avec ses propriétés
    echo "</pre>";

    if( $tour->createTournee($id_utilisateur)){
        $id_tournee = $tour->getIDTournee($code_tournee);

        $annee = date('Y');
        $new_code = substr($ville,0,3)."".$annee."_".$id_tournee;
        $tour->updateTourneecode($new_code);

        echo "<pre>";
            //var_dump($new_code);
        echo "</pre>";
        
        $tour->code = $new_code;
        $tour->create($tour->code);
        echo "La tournée a été créée avec succès. dernier ID enregistrer : ".$last_id;

        switch($_SESSION['role']) {
            case 'Admin': $location ="../../../pages/tournee-res-com.php"; 
                break;
            case 'Commercial':$location ="../../../pages/tournee-com.php";
                break;
            case 'responsable_commercial': $location ="../../../pages/tournee-res-com.php";
                break;
        }
        header("Location:".$location);
    } else {
        echo "Une erreur s'est produite lors de la création de la tournée.";
    }
}
?>
