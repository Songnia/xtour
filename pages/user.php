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
    <button id="addButton" class="add-store-btn" onclick="openModal()" >Ajouter un Utilisateur</button>
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
            <button class="edit-btn" onclick="openEditModalUser('Paul', 'Commercial', '13-10-2023')">Éditer</button>
            <button class="delete-btn" onclick="openvalidationModal()">Supprimer</button>
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
    <span class="close-button" onclick="closeModal()">&times;</span>
    <h2  id="modalTitle">Ajouter un utilisateur</h2>
    
    <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
    <div class="form-col">
      <div>
        <input type="hidden" name="user_id">
      </div>
      <div>
        <label for="store">Nom</label>
        <input id="username" name="username" type="text" class="form-input-text" placeholder="Nom...">
      </div>
      
      <div>
      <label for="role" >Role</label>
      <select id="role">
          <option value="Admin">Admin</option>
          <option value="Commercial">Commercial</option>
          <option value="Responsable Commercial">Responsable Commercial</option>
          <!-- Autres options ici -->
      </select>
      </div>
      <div>
      <label for="commercial">Date d arriver dans l entreprise</label>
      <input id="datecom" name="datecom" type="date">
      </div>
      
    </div>
    <!-- Bouton Ajouter en bas -->
    <button  type="submit" class="add-button">Ajouter</button>

  </div>
</div>
<style>

.validationModal{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 25px;
}
.btn-container-val{
  display: flex;
  justify-content: center;
  gap: 5px;
  width: 100%;
}

</style>

<div id="validationModal" class="modal">
  <div class="modal-content validationModal">
    <span class="close-button" onclick="closeModal()">&times;</span>
    <div class="image">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
    </div>
    Confirmer la supression!
    <!-- Bouton Ajouter en bas -->
    <div class="btn-container-val">
        <button  type="submit" class="add-button">Oui</button>
        <button  type="submit" class="add-button">Non</button>
    </div>
  </div>
</div>

<?php include("../includes/footer.php"); ?>
