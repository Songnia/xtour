
  <!-- Sidebar -->
  
  <aside class="sidebar">
    <div class="logo">
      <img src="path/to/logo.png" alt="Logo"> <!-- Remplacez par le chemin de votre logo -->
    </div>
    <h2>Admin Tools</h2>
    <nav class="nav">
      <a href="../pages/dashboard.php" class="nav-link active">Overview</a>
      <a href="../pages/rapport.php" class="nav-link ">Tournées</a>
      <a href="../pages/magasin.php" class="nav-link ">Magasins</a>
      <a href="../pages/visite.php" class="nav-link">Visite</a>
      <a href="../pages/livraison.php" class="nav-link">Livraison</a>
      <a href="../pages/produit.php" class="nav-link">Produits</a>
      <a href="../pages/user.php" class="nav-link">Utilisateurs</a>
    </nav>
    <div class="sign-out">
      <a href="../pages/connexion.php">Sign Out</a>
    </div>
  </aside>
  <!-- Main Content -->
  <main class="main-content">
    <!-- Header -->
    <?php include_once("header-notif.php");  ?>
    
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