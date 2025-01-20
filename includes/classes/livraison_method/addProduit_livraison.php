<?php

include_once("../Database.php");
include_once("../Livraison.php");
include_once("../Produit.php");


$database = new Database();
$db = $database->getConnection();

$livraison = new Livraison($db);
$produit = new Produit($db);
echo"<pre>";
var_dump(value: $_POST);
echo"</pre>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $livraison_id = htmlspecialchars(trim($_POST['livraison_id']));    
      $id_produit = htmlspecialchars(trim($_POST['produit']));
      $quantite = htmlspecialchars(trim($_POST['quantite']));
      $date_fabrication = htmlspecialchars(trim($_POST['dateFab']));
      $date_expiration = htmlspecialchars(trim($_POST['dateExp']));

      $name_produit = $produit->getNameProduit($id_produit);

    // Affecter les valeurs aux propriétés de l'objet Livraison
    $livraison->produit_id = $id_produit;
    $livraison->nom_produit = $name_produit;
    $livraison->quantite = $quantite;
    $livraison->date_fabrication = $date_fabrication;
    $livraison->date_expiration = $date_expiration;
    echo"<pre>";
      var_dump($livraison);
    echo"</pre>";
    if ($livraison->addProduit($livraison_id)) {
          echo "Produit enregistrer";
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
          header("Location:" . $location);
        }else{
          echo "Produit non enregistrer";
        }
}
