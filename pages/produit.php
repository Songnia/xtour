<?php
$titre = "produit";
include("../includes/sidebar-mobile.php");

//Inserer le header
include("../includes/header.php");

// Inserer la Sidebar
include("../includes/sidebar.php");
?>


<!-- Main Content -->
<main class="main-content1">
  <!-- Page Title -->
  <div class="page-title">
    <h1>Produits</h1>
  </div>
  
  <!-- Search and Add New Store -->
  <div class="store-actions">
    <input type="text" placeholder="Rechercher un Produit..." class="search-store">
    <button id="addButton" class="add-store-btn">Ajouter un Produit</button>
  </div>
  
  <!-- Stores Table -->
  <div class="container-scroll">
    <div class="table-section">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom commercial</th>
          <th>Nom descriptif</th>
          <th>Prix public (fcfa)</th>
          <th>Poids (l/g)</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Produit A</td>
          <td>Location A</td>
          <td>Location A</td>
          <td>50</td>
          <td>
            <!--<button class="view-btn">Voir</button>-->
            <button class="edit-btn">Éditer</button>
            <button class="delete-btn">Supprimer</button>
          </td>
        </tr>
        <!-- Ajouter d'autres lignes pour chaque Produit -->
      </tbody>
    </table>
  </div>
  </div>
  
</main>

<div id="productModal" class="modal">
  <div class="modal-content">
    <span class="close-button">&times;</span>
    <h2>Ajouter un produit</h2>
    
    <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
    <div class="form-col">
      <div>
        <label for="store">Nom Commercial</label>
        <input name="NomCommercial" type="text" class="form-input-text" placeholder="Noms Commercial...">
      </div>
      
      <div>
      <label for="store">Noms Descriptif</label>
      <input name="Noms Descriptif" type="text" class="form-input-text" placeholder="Noms Descriptif...">
      </div>
      <div>
          <label for="Prix">Prix(Fcfa)</label>
          <input name="prix" type="number">
      </div>
      <div>
          <label for="Poids">Poids(l/g)</label>
          <input name="poids" type="number">
      </div>
    </div>
    <!-- Bouton Ajouter en bas -->
    <button class="add-button">Ajouter</button>

  </div>
</div>



<?php include("../includes/footer.php"); ?>
