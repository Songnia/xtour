
  <!-- Sidebar -->
  <?php 
session_start();
// Récupérer le nom de la page actuelle
$currentPage = basename($_SERVER['PHP_SELF']);

$location ="";

switch($_SESSION['role']) {/*'Admin', 'Commercial', 'responsable_commercia...*/
    case 'Admin': $location ="../pages/tournee-com.php"; ;
        break;
    case 'Commercial':$location ="../pages/tournee-com.php";;
        break;
    case 'responsable_commercial': $location ="../pages/tournee-res-com.php";;
        break;
}
?>
  
  <aside class="sidebar">
    <div class="logo">
      <img src="../assets/logoNgon.png" alt="Logo"> <!-- Remplacez par le chemin de votre logo -->
    </div>
    <h2>

    <?php
      switch($_SESSION['role']) {
        case 'Admin': echo $_SESSION['role'] ;
            break;
        case 'Commercial':echo $_SESSION['role'];
            break;
        case 'responsable_commercial': echo "R commercial";
            break;
      }?> Tools</h2>
      
    <nav class="nav">
      <a href="<?php echo $location; ?>" class="nav-link <?php echo (strpos($currentPage, 'tournee') !== false) ? 'active' : ''; ?>">Planifier</a>
      <!--<a href="../pages/visite.php" class="nav-link">Visite</a> -->
      <a href="../pages/livraison.php" class="nav-link <?php echo ($currentPage == 'livraison.php') ? 'active' : ''; ?>">Livraison</a>
      <?php if ($_SESSION['role'] == 'Commercial') { ?>
        <a href="../pages/alerte.php" class="nav-link <?php echo ($currentPage == 'alerte.php') ? 'active' : ''; ?>">Alerte</a>
      <?php } ?>
      <a href="../pages/magasin.php" class="nav-link <?php echo ($currentPage == 'magasin.php') ? 'active' : ''; ?>">Magasin</a>
      <a href="../pages/rapport.php" class="nav-link <?php echo ($currentPage == 'rapport.php') ? 'active' : ''; ?>">Tournees</a>
    </nav>
    <div class="sign-out">
      <a href="../index.php">Sign Out</a>
    </div>
  </aside>
  <!-- Main Content -->
  <main class="main-content">
    <!-- Header -->
    <?php include_once("header-notif.php");  ?>