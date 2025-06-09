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

// Déterminer le nom de la page de tournée pour le lien "Tournées"
$namePage = '';
if ($_SESSION['role'] === 'Commercial') {
    $namePage = 'rapport-com.php';
} elseif ($_SESSION['role'] === 'responsable_commercial') {
    $namePage = 'rapport-res-com.php';
} else { // Admin ou autre
    $namePage = 'rapport.php';
}

?>

<header class="header-mobile">
    <div class="logo"><img src="../assets/logoNgon.png" alt=""></div>
    <h1>
    <?php
      switch($_SESSION['role']) {
        case 'Admin': echo $_SESSION['role'] ;
            break;
        case 'Commercial':echo $_SESSION['role'];
            break;
        case 'responsable_commercial': echo "R commercial";
            break;
      }?> Tool
        
    </h1>
    <button class="menu-btn" id="menuToggle">&#9776;</button>
</header>

<aside class="sidebarMobile" id="sidebarMobile">
    <button class="close-btn" id="closesidebarMobile">&times;</button>
    <div class="tools">
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
        <a href="../pages/<?= $namePage ?>" class="tool-btn nav-link <?php echo (strpos($currentPage, 'rapport') !== false) ? 'active' : ''; ?>">Tournées</a>
        
        <a href="<?php echo $location; ?>" class="tool-btn nav-link <?php echo (strpos($currentPage, 'tournee') !== false) ? 'active' : ''; ?>">Planifier</a>
        <a href="../pages/livraison.php" class="tool-btn nav-link <?php echo ($currentPage == 'livraison.php') ? 'active' : ''; ?>">Livraison</a>
        <?php if ($_SESSION['role'] == 'Commercial') { ?>
          <a href="../pages/alerte.php" class="tool-btn nav-link <?php echo ($currentPage == 'alerte.php') ? 'active' : ''; ?>">Alerte</a>
        <?php } ?>
        <a href="../index.php" class="tool-btn nav-link">Sign Out</a>    
    </div>
</aside>