<!-- Sidebar -->
<?php 
session_start();
// Récupérer le nom de la page actuelle
$currentPage = basename($_SERVER['PHP_SELF']); 

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
  
<aside class="sidebar">
    <div class="logo">
        <img src="../assets/logoNgon.png" alt="Logo">
    </div>
    <h2>
    <?php
    switch ($_SESSION['role']) {
        case 'Admin': 
            echo $_SESSION['role'];
            break;
        case 'Commercial':
            echo $_SESSION['role'];
            break;
        case 'responsable_commercial': 
            echo "R commercial";
            break;
    }
    ?> Tools</h2>
    <nav class="nav">
        <a href="../pages/dashboard.php" class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">Overview</a>
        <a href="../pages/rapport.php" class="nav-link <?php echo ($currentPage == 'rapport.php') ? 'active' : ''; ?>">Tournées</a>
        <a href="../pages/magasin.php" class="nav-link <?php echo ($currentPage == 'magasin.php') ? 'active' : ''; ?>">Magasins</a>
        <a href="<?php echo $location; ?>" class="nav-link <?php echo (strpos($currentPage, 'tournee') !== false) ? 'active' : ''; ?>">Planifier</a>
        <a href="../pages/livraison.php" class="nav-link <?php echo ($currentPage == 'livraison.php') ? 'active' : ''; ?>">Livraison</a>
        <?php if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'responsable_commercial') { ?>
          <a href="../pages/alerte.php" class="nav-link <?php echo ($currentPage == 'alerte.php') ? 'active' : ''; ?>">Alerte</a>
        <?php } ?>
        <a href="../pages/produit.php" class="nav-link <?php echo ($currentPage == 'produit.php') ? 'active' : ''; ?>">Produits</a>
        <a href="../pages/user.php" class="nav-link <?php echo ($currentPage == 'user.php') ? 'active' : ''; ?>">Utilisateurs</a>
    </nav>
    <div class="sign-out">
        <a href="../index.php">Sign Out</a>
    </div>
</aside>

<!-- Main Content -->
<main class="main-content">
    <!-- Header -->
    <?php include_once("header-notif.php"); ?>
    
    <div id="alertModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Ajouter un Magasin</h2>
            
            <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
            <div class="form-col">
                <div>
                    <label for="store">Magasin</label>
                    <select id="store">
                        <option value="ampliat">Ampliat...</option>
                        <!-- Autres options ici -->
                    </select>
                </div>
                
                <div>
                    <label for="lieu">Lieu</label>
                    <select id="lieu">
                        <option value="ampliat">Douala</option>
                        <!-- Autres options ici -->
                    </select>
                </div>
            </div>
        </div>
    </div>  