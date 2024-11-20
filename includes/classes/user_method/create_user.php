<?php
  include_once("../Database.php");
  include_once("../User.php");

  $database = new Database();
  $db = $database->getConnection();
  $utilisateur = new Utilisateur($db);
  
  if($_SERVER['REQUEST_METHOD'] === "POST"){
    $utilisateur->nom = htmlspecialchars(trim($_POST["nom"]));
    $utilisateur->prenom = htmlspecialchars(trim($_POST["prenom"]));
    $utilisateur->date_arrive_dans_entreprise = htmlspecialchars(trim($_POST["date_arrive_dans_entreprise"]));
    $utilisateur->role = htmlspecialchars(trim($_POST["role"]));
        
    // Verifier si l utilisateur existe
    if(!empty($_POST["utilisateur_id"])){
      $utilisateur->id_utilisateur = $_POST["utilisateur_id"];
      if($utilisateur->update()){
        header("Location: ../../../pages/user.php");
      }else{
        echo "Erreur lors de la mise a jour de l Utilisateur";
      }
    }else{
      if($utilisateur->create()){
        header("Location: ../../../pages/user.php");
      }else{
        echo "Erreur lors de la creation de l utilisateur";
      }
    }
  }
?>