<?php
$titre = "Utilisateur";
include("../includes/sidebar-mobile.php");

//Inserer le header
include("../includes/header.php");

// Inserer la Sidebar
include("../includes/sidebar.php");

include_once("../includes/classes/Database.php");
include_once("../includes/classes/User.php");

$database = new Database();
$db = $database->getConnection();
$utilisateur = new Utilisateur($db);
$users = $utilisateur->read();
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
    <button id="addButton" class="add-store-btn" onclick="openModalProduit()" >Ajouter un Utilisateur</button>
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
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($users as $user): ?>
        <tr>
          <td><?php echo htmlspecialchars($user['id_utilisateur']) ?></td>
          <td><?php echo htmlspecialchars($user['nom']." ".$user['prenom']) ?></td>
          <td><?php echo htmlspecialchars($user['role']) ?></td>
          <td>Ampiat, Santa Loucia</td>
          <td>
            <!--<button class="view-btn">Voir</button> -->
            <button class="edit-btn" onclick="openEditModalUser('<?php echo $user['id_utilisateur']; ?>','<?php echo $user['nom']; ?>', '<?php echo $user['prenom']; ?>', '<?php echo $user['role']; ?>','<?php echo $user['date_arrive_dans_entreprise']; ?>')" >Éditer</button>                                                             
            <button class="delete-btn" onclick="openDeleteModal_utilisateur('<?php echo $user['id_utilisateur']; ?>')">Supprimer</button>
          </td>
        </tr>
        <?php endforeach; ?>
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
    <form method="POST" action="../includes/classes/user_method/create_user.php" class="form-col">
      <div>
        <input type="hidden" id="utilisateur_id" name="utilisateur_id" required="">
      </div>
      <div>
        <label for="store">Nom</label>
        <input required="" id="utilisateur_nom" name="nom" type="text" class="form-input-text" placeholder="Nom...">
      </div>
      <div>
        <label for="store">Prenom</label>
        <input required="" id="utilisateur_prenom" name="prenom" type="text" class="form-input-text" placeholder="Nom...">
      </div>
      <div>
      <label for="role" >Role</label>
      <select  id="utilisateur_role" name="role">
          <option vrequired=""alue="Admin">Admin</option>
          <option value="Commercial">Commercial</option>
          <option value="Responsable Commercial">Responsable Commercial</option>
          <!-- Autres options ici -->
      </select>
      </div>
      <div>
      <label for="date_arrive_dans_entreprise">Date d arriver dans l entreprise</label>
      <input required="" id="utilisateur_date_arrive_dans_entreprise" name="date_arrive_dans_entreprise" type="date">
      </div>
      <button  type="submit" class="add-button">Ajouter</button>
    </form>

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

<div id="modal3" class="modal">
  <div class="modal-content validationModal">
    <span class="close-button" onclick="closeModalValidation()">&times;</span>
    <div class="image">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
    </div>
    Confirmer la supression!
    <!-- Bouton Ajouter en bas -->
    <form  method="POST" action="../includes/classes/user_method/delete_user.php" class="btn-container-val">
        <input type="hidden" name="utilisateur_id" id="delete_utilisateur_id">
        <button  type="submit" id="delete_utilisateur" class="add-button" >Supprimer</button>
        <button  class="add-button" onclick="closeModalValidation()">Non</button>
    </form>
    
  </div>
</div>

<?php include("../includes/footer.php"); ?>
