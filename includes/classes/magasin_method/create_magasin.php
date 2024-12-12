<?php

include_once("../Database.php");
include_once("../Magasin.php");

$database = new Database();
$db = $database->getConnection();
$magasin = new Magasin($db);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $magasin->nom = htmlspecialchars(trim($_POST["nom"]));
  $magasin->type = htmlspecialchars(trim($_POST["type"]));
  $magasin->chefMagasinName = htmlspecialchars(trim($_POST["chefMagasinName"]));
  $magasin->contactChef = htmlspecialchars(trim($_POST["contactChef"]));
  echo"<pre>";
  var_dump($_POST);
  echo"</pre>";
  // Collecter les contacts supplémentaires
  $contacts = [];
  for ($i = 1; $i <= 3; $i++) {
      $contactName = isset($_POST["contactName$i"]) ? htmlspecialchars(trim($_POST["contactName$i"])) : null;
      $contact = isset($_POST["contact$i"]) ? htmlspecialchars(trim($_POST["contact$i"])) : null;

      if (!empty($contactName) && !empty($contact)) {
          $contacts[] = [
              "name" => $contactName,
              "contact" => $contact,
          ];
      }
  }

  // Appel de la méthode create()
  if ($magasin->create($contacts)) {
      //header("Location: ../../../pages/magasin.php");
  } else {
      echo "Erreur lors de l'ajout du magasin.";
  }
}



?>