<?php

include_once("../Database.php");
include_once("../Magasin.php");

$database = new Database();
$db = $database->getConnection();

$magasin = new Magasin($db);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
 /* var_dump($_POST);*/

  $id_magasin =  htmlspecialchars(trim($_POST["id_magasin"]));
  $name = htmlspecialchars(trim($_POST["name"]));
  $role = htmlspecialchars(trim($_POST["role"]));
  $phone = htmlspecialchars(trim($_POST["phone"]));
  $relation = json_encode($_POST["relation"]);
  echo "Hello0";
  $magasin->addContact($id_magasin,$role, $name,$phone,$relation);
  header("Location: ../../../pages/magasin.php");
  
}

?>