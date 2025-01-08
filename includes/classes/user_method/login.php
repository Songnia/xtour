<?php 

//Connexion avec la BD
include_once("../Database.php");
include_once("../User.php");

$database = new Database();
$db = $database->getConnection();
$utilisateur = new Utilisateur($db);


if($_SERVER['REQUEST_METHOD'] === "POST"){
    // Validation des données d'entrée
    $pass = $_POST['pass'];
    $user_name = $_POST['user_name'];
    
    // Requête préparée pour récupérer le nom et le prénom
    try{
        $stmt = $db->prepare("SELECT * FROM Utilisateur WHERE mot_de_passe = :pass");
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        $user = $stmt->fetch();
    } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
  }     
  echo "<pre>";
    var_dump($user);
  echo "</pre>";

    // Vérifie si l'utilisateur existe et si le mot de passe est correct
    if($user) {
        session_start();
        
        // Enregistrement des données dans la session
        $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];
        $_SESSION['role'] = $user['role'];
        /*$_SESSION['nom'] = $user['nom'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['nom'] = $user['nom'];*/

        //$_SESSION['prenom'] = $user['prenom'];
        //$USER = $_SESSION['nom'];
        
        
        // Redirection vers le dashboard
       header("location:../../../pages/dashboard.php");
        exit;
    } else {
        // Gérer l'erreur, par exemple : utilisateur ou mot de passe incorrect
        echo "Utilisateur ou mot de passe incorrect";
    }
}
?>
