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
    $utilisateur->mot_de_passe = bin2hex(random_bytes(length: 12 / 2));
    $commerciaux = $_POST["id_commerciaux"];

    $nom = $utilisateur->nom;
    $prenom = $utilisateur->prenom;
    $utilisateur->nom_utilisateur = substr($nom,0,3)."".substr($prenom,0,2);
    
    // Verifier si l utilisateur existe
    echo "<pre>";
      //var_dump($_POST);
      var_dump($commerciaux);
    echo "</pre>";
    if(!empty($_POST["utilisateur_id"])){
      $utilisateur->id_utilisateur = $_POST["utilisateur_id"];
      if($utilisateur->update()){
        header("Location: ../../../pages/user.php");
      }else{
        echo "Erreur lors de la mise a jour de l Utilisateur";
      }
    }else{
      if($utilisateur->create()){
        $pass = $utilisateur->mot_de_passe;
        $id_user = $utilisateur->getIDUser($pass);
        echo "<pre>";
         //var_dump($id_user);
        echo "</pre>";

        foreach ($commerciaux as $com):          // Vérifier si un produit a été trouvé
          // Appel de la méthode addProduit
          $name = $utilisateur->readComerciaux_code($com);
          $name = $name[0]['nom_utilisateur'];
          $utilisateur->attributCommerciaux($name, $id_user, $com);
        endforeach;
        /*$newcode = $id_user."".$pass;
        echo "<pre>";
        var_dump($newcode);
       echo "</pre>";*/
        //$utilisateur->updatePassword($newcode);
       header("Location: ../../../pages/user.php");
      }else{
        echo "Erreur lors de la creation de l utilisateur";
      }
    }
  }
?>