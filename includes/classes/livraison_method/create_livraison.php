<?php
session_start();
$id_utilisateur = $_SESSION['id_utilisateur'];
$role_utilisateur = $_SESSION['role'];

include_once("../Database.php"); 
include_once("../Livraison.php");
include_once("../Produit.php");
$database = new Database();
$db = $database->getConnection();
$livraison = new Livraison($db);
$produit = new Produit($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assainir et valider les données entrantes
    $ville = htmlspecialchars(trim($_POST['ville']));
    $nom_magasin = htmlspecialchars(trim($_POST['nom_magasin']));
    $id_produit = htmlspecialchars(trim($_POST['produit']));
    $quantite = htmlspecialchars(trim($_POST['quantite']));
    $date_fabrication = htmlspecialchars(trim($_POST['dateFab']));
    $date_expiration = htmlspecialchars(trim($_POST['dateExp']));

    // Vérifier si les champs sont remplis correctement
    if (empty($ville) || empty($nom_magasin) || empty($produit) || empty($quantite)) {
        echo "Tous les champs sont obligatoires.";
        echo"<pre>";
          //var_dump($_POST);
        echo"<pre>";

        echo "Ville ".$ville."<br>";
        echo "nom_magasin ".$nom_magasin."<br>";
        echo "produit ".$id_produit."<br>";
        echo "quantite ".$quantite."<br>";
        return;
    }

    // Générer un code unique pour la livraison
    $annee = date('Y');
    $code_livraison = "Liv" . substr( $ville, 0, 3) ."".$annee;
    echo"<pre>";
      //var_dump($_POST);
    echo"<pre>";
    $name_produit = $produit->getNameProduit($id_produit);

    // Affecter les valeurs aux propriétés de l'objet Livraison
    $livraison->ville = $ville;
    $livraison->magasin_id = $nom_magasin;
    $livraison->produit_id = $id_produit;
    $livraison->nom_produit = $name_produit;
    $livraison->quantite = $quantite;
    $livraison->date_fabrication = $date_fabrication;
    $livraison->date_expiration = $date_expiration;
    $livraison->code = $code_livraison;
    echo"<pre>";
      //var_dump($livraison);
    echo"<pre>";
    if ($livraison->create()) {
        $id_livraison = $livraison->getIDLivraison($code_livraison);
        echo "ID: ".$id_livraison['id_livraison'] ."<br>";

        $new_code = $livraison->code. "_" . $id_livraison['id_livraison']."".$livraison->magasin_id ;
        echo "ID: ".$new_code ."<br>";
        $livraison->code = $new_code;
        $livraison->id_livraison = $id_livraison['id_livraison'];
        if($livraison->updateLivraisonCode($new_code)){
          echo "code enregistrer";
        }else{
          echo "code non enregistrer";
        }
        if($livraison->addProduit($livraison->id_livraison)){
          echo "Produit enregistrer";
        }else{
          echo "Produit non enregistrer";
        }


        echo "La livraison a été créée avec succès.";
        $location = "../../../pages/livraison.php";
        // Redirection en fonction du rôle de l'utilisateur
        switch ($_SESSION['role']) {
            case 'Admin':
                $location = "../../../pages/livraison.php";
                break;
            case 'Commercial':
                $location = "../../../pages/livraison-com.php";
                break;
            case 'responsable_commercial':
                $location = "../../../pages/livraison-res-com.php";
                break;
        }
        //header("Location:" . $location);
    } else {
        echo "Une erreur s'est produite lors de la création de la livraison.";
    }
}
?>
