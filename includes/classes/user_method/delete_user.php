<?php
include_once("../Database.php");
include_once("../User.php");

$database = new Database();
$db = $database->getConnection();
$utilisateur = new Utilisateur($db);

$utilisateur->id_utilisateur = htmlspecialchars(trim($_POST["utilisateur_id"]));

if ($utilisateur->delete()){
  header("Location: ../../../pages/user.php");
}else{
  echo "Erreur lors de la suppression du produit";
}

?>