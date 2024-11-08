<?php
$titre = "Utilisateur";
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
    <h1>Utilisateurs</h1>
  </div>
  
  <!-- Search and Add New Store -->
  <div class="store-actions">
    <input type="text" placeholder="Rechercher un Utilisateur..." class="search-store">
    <button id="addButton" class="add-store-btn">Ajouter un Utilisateur</button>
  </div>
  
  <!-- Stores Table -->
  <div class="container-scroll">
    <div class="table-section">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom du Utilisateur</th>
          <th>Roles</th>
          <th>Magasins</th>
          <!--<th>Utilisateurs Disponibles</th>-->
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Utilisateur A</td>
          <!--<td>Location A</td>-->
          <td>Admin</td>
          <td>Ampiat, Santa Loucia</td>
          <td>
            <!--<button class="view-btn">Voir</button> -->
            <button class="edit-btn">Éditer</button>
            <button class="delete-btn">Supprimer</button>
          </td>
        </tr>
        <!-- Ajouter d'autres lignes pour chaque Utilisateur -->
      </tbody>
    </table>
  </div>
  </div>
  
</main>
<!-- Pop-up Modal -->
<div id="productModal" class="modal">
  <div class="modal-content">
    <span class="close-button">&times;</span>
    <h2>Ajouter un utilisateur</h2>
    
    <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
    <div class="form-col">
      
      <div>
        <label for="store">Nom</label>
        <input name="nom" type="text" class="form-input-text" placeholder="Nom...">
      </div>
      
      <div>
      <label for="date">Role</label>
      <select id="commercial">
          <option value="Admin">Admin</option>
          <option value="Commercial">Commercial</option>
          <option value="Responsable Commercial">Responsable Commercial</option>
          <!-- Autres options ici -->
      </select>
      </div>
      <div>
      <label for="commercial">Date d arriver dans l entreprise</label>
      <input name="date" type="date">
      </div>
      
    </div>
    <!-- Bouton Ajouter en bas -->
    <button class="add-button">Ajouter</button>

  </div>
</div>



<?php include("../includes/footer.php"); ?>
