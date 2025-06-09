<?php
if (!isset($_SESSION['id_utilisateur']) && $titre!="Acceuil") { 
  // L'utilisateur n'est pas connecté
  header("Location: ../includes/erreur.php"); // Rediriger vers une page d'erreur
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $titre ??"Acceuil"?></title>
  <link rel="stylesheet" href="../css/style.css"> <!-- Fichier CSS séparé -->
  <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    