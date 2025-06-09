<?php 
session_start();
// Récupérer le nom de la page actuelle
$currentPage = basename($_SERVER['PHP_SELF']); 

// Déterminer la page 'Planifier' en fonction du rôle pour les liens directs si nécessaire
$location = "";
switch ($_SESSION['role']) {
    case 'Admin':
        $location = "../pages/tournee-res-com.php"; 
        break;
    case 'Commercial':
        $location = "../pages/tournee-com.php";
        break;
    case 'responsable_commercial':
        $location = "../pages/tournee-res-com.php";
        break;
}
?>
<header class="header-mobile">
    <div class="logo"><img src="../assets/logoNgon.png" alt=""></div>
    <a href="../pages/dashboard.php"><h1>HOME</h1></a>
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
            }?>
            Tools</h2>
        <a href="../pages/dashboard.php" class="tool-btn nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">Overview</a>
        <a href="../pages/rapport.php" class="tool-btn nav-link <?php echo ($currentPage == 'rapport.php') ? 'active' : ''; ?>">Tournées</a>
        <a href="../pages/magasin.php" class="tool-btn nav-link <?php echo ($currentPage == 'magasin.php') ? 'active' : ''; ?>">Magasins</a>
        <a href="<?php echo $location; ?>" class="tool-btn nav-link <?php echo (strpos($currentPage, 'tournee') !== false) ? 'active' : ''; ?>">Planifier</a>
        <a href="../pages/livraison.php" class="tool-btn nav-link <?php echo ($currentPage == 'livraison.php') ? 'active' : ''; ?>">Livraison</a>
        <?php if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'responsable_commercial') { ?>
        <a href="../pages/alerte.php" class="tool-btn nav-link <?php echo ($currentPage == 'alerte.php') ? 'active' : ''; ?>">Alerte</a>
        <?php } ?>
        <a href="../pages/produit.php" class="tool-btn nav-link <?php echo ($currentPage == 'produit.php') ? 'active' : ''; ?>">Produits</a>
        <a href="../pages/user.php" class="tool-btn nav-link <?php echo ($currentPage == 'user.php') ? 'active' : ''; ?>">Utilisateurs</a>
        <a href="../index.php" class="tool-btn nav-link">Sign Out</a>

    </div>
</aside>