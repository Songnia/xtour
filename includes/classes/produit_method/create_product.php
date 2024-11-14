<?php
    include_once("../Database.php");
    include_once("../Produit.php");

    $database = new Database();
    $db = $database->getConnection();
    $produit = new Produit($db);


    // Recu[erer les produits du formulaire
    if($_SERVER["REQUEST_METHOD"] == "POST") {

      $produit->nom_commercial = htmlspecialchars(trim($_POST["nom_commercial"]));
      $produit->nom_descriptif = htmlspecialchars(trim($_POST["nom_descriptif"]));
      $produit->poids = htmlspecialchars(trim($_POST["poids"]));
      $produit->prix = htmlspecialchars(trim($_POST["prix"]));
    }


    if ($produit->create()) {
        header("Location: ../../../pages/produit.php");
        //echo "Produit ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du produit.";
    }
  ?>