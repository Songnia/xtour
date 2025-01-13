<?php 
session_start();
?>
<header class="header-mobile">
    <div class="logo"><img src="../assets/logo1.png" alt=""></div>
    <h1>HOME</h1>
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
        <a href="../pages/dashboard.php" class="tool-btn nav-link active">Overview</a>
        <a href="../pages/rapport.php" class="tool-btn nav-link">Tournées</a>
        <a href="../pages/magasin.php" class="tool-btn nav-link">Magasins</a>
        <a href="../pages/tournee-com.php" class="tool-btn nav-link">Planifier</a>
        <a href="../pages/livraison.php" class="tool-btn nav-link">Livraison</a>
        <a href="../pages/produit.php" class="tool-btn nav-link">Produits</a>
        <a href="../pages/user.php" class="tool-btn nav-link">Utilisateurs</a>
        <a href="../index.php" class="tool-btn nav-link">Sign Out</a>

    </div>
</aside>