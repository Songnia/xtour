<?php 
session_start();
$location ="";

switch($_SESSION['role']) {/*'Admin', 'Commercial', 'responsable_commercia...	*/
    case 'Admin': $location ="../pages/tournee-com.php"; ;
        break;
    case 'Commercial':$location ="../pages/tournee-com.php";;
        break;
    case 'responsable_commercial': $location ="../pages/tournee-res-com.php";;
        break;
}
?>

<header class="header-mobile">
    <div class="logo"><img src="../assets/logo1.png" alt=""></div>
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
        <a href="../pages/<?= $namePage ?>" class="tool-btn nav-link">Tournées</a>
        
        <a href="<?php echo $location; ?>" class="tool-btn nav-link">Planifier</a>
        <a href="../pages/livraison.php" class="tool-btn nav-link">Livraison</a>
        <a href="../index.php" class="tool-btn nav-link">Sign Out</a>    
    </div>
</aside>