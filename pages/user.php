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

echo "<pre>";
//var_dump($users);
echo "</pre>";
?>

<!-- Main Content -->
<main class="main-content1">
  <!-- Page Title -->
  <div class="page-title">
    <h1>Utilisateurs</h1>
  </div>
  
  <!-- Search and Add New Store -->
  <div class="store-actions">
  <div class="group1" style="width: 80%">
        <input type="text" placeholder="Rechercher" class="search-store" id="searchInput"  >
        <svg id="go" class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
  </div>    
  <button id="addButton" class="add-store-btn" onclick="openModalProduit()" >Ajouter un Utilisateur</button>
  </div>
  <div id="containterFilter">
  <div id="elementsFilter">
    <!-- Filtre Par Magasin -->
    <div class="divFilter">
        <label for="filter_magasin">Par Magasin :</label>
        <div class="radio-inputs">
            <label class="radio" for="magasin1">
                <input id="magasin1" type="radio" name="radio_magasin" value="magasin1" checked="">
                <span class="name">Magasin1</span>
            </label>
            <label class="radio" for="magasin2">
                <input id="magasin2" type="radio" name="radio_magasin" value="magasin2">
                <span class="name">Magasin2</span>
            </label>
            <label class="radio" for="magasin3">
                <input id="magasin3" type="radio" name="radio_magasin" value="magasin3">
                <span class="name">Magasin3</span>
            </label>
        </div>
    </div>

    <!-- Filtre Par Produit -->
    <div class="divFilter">
        <label for="filter_produit">Par Produit :</label>
        <div class="radio-inputs">
            <label class="radio" for="produit1">
                <input id="produit1" type="radio" name="radio_produit" value="produit1" checked="">
                <span class="name">Produit1</span>
            </label>
            <label class="radio" for="produit2">
                <input id="produit2" type="radio" name="radio_produit" value="produit2">
                <span class="name">Produit2</span>
            </label>
            <label class="radio" for="produit3">
                <input id="produit3" type="radio" name="radio_produit" value="produit3">
                <span class="name">Produit3</span>
            </label>
        </div>
    </div>

    <!-- Filtre Par Date -->
    <div class="divFilter">
        <label for="filter_date">Par Date :</label>
        <div class="radio-inputs">
            <label class="radio" for="recent">
                <input id="recent" type="radio" name="radio_date" value="recent" checked="">
                <span class="name">Plus récent d'abord</span>
            </label>
            <label class="radio" for="moins_recent">
                <input id="moins_recent" type="radio" name="radio_date" value="moins_recent">
                <span class="name">Moins récent d'abord</span>
            </label>
        </div>
    </div>
</div>

  </div>
  <!-- Stores Table -->
  <div class="container-scroll">
    <div class="table-section">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom du Utilisateur</th>
          <th>mot de passe</th>
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
          <td><?php echo htmlspecialchars($user['mot_de_passe']) ?></td>
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
          <option value="responsable_commercial">Responsable Commercial</option>
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
