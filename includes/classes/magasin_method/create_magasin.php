<?php

include_once("../Database.php");
include_once("../Magasin.php");

$database = new Database();
$db = $database->getConnection();
$magasin = new Magasin($db);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  
    $magasin->ville = htmlspecialchars(trim($_POST["ville"]));
    $magasin->nom = htmlspecialchars(trim($_POST["nom"]));
    $magasin->type = htmlspecialchars(trim($_POST["type"]));
    
    $name = htmlspecialchars(trim($_POST["name"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $relation = json_encode($_POST["relation"]);

  echo"<pre>";
  var_dump(value: $name);
  echo"</pre>";
  echo"<pre>";
  var_dump(value: $phone);
  echo"</pre>";
  echo"<pre>";
  var_dump(value: $relation);
  echo"</pre>";

    echo "LE MAGASIN";
  echo"<pre>";
  var_dump(value: $magasin);
  echo"</pre>";
 
  

  // Appel de la méthode create()
  if ($magasin->create()) {
      // Collecter les contacts supplémentaires
      $maga = $magasin->getIDMagasin($magasin->nom);
      echo $maga['id_magasin'];
      if($magasin->addContact($maga['id_magasin'],$name,$phone,$relation)){
          echo" contact ajouter";
      }   

      header("Location: ../../../pages/magasin.php");
  } else {
      echo "Erreur lors de l'ajout du magasin.";
  }
}



?>