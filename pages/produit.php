<link rel="icon" type="image/png" sizes="32x32" href="Visimags-carre1.png">
<?php

$titre = "produit";
include("../includes/sidebar-mobile.php");

//Inserer le header
include("../includes/header.php");

// Inserer la Sidebar
include("../includes/sidebar.php");
include("../includes/config.php");

include_once("../includes/classes/Database.php");
include_once("../includes/classes/Produit.php");

$database = new Database();
$db = $database->getConnection();
$produit = new Produit($db);

// Lecture des produits
$prods = $produit->read();
/*echo"<pre>";
var_dump($prods);
echo"</pre>";*/


?>

<!-- Main Content -->
<main class="main-content1">  
  <!-- Page Title -->
  <div class="page-title">
    <h1>Produits</h1>
  </div>
  
  <!-- Search and Add New Store -->
  <div class="store-actions">
    <div class="group1" style="width: 80%">
        <input type="text" placeholder="Rechercher" class="search-store" id="searchInput"  >
        <svg id="go" class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
    </div>
    <button id="addButton" class="add-store-btn" onclick="openModalProduit()">Ajouter un Produit</button>
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
          <th>Nom commercial</th>
          <th>Nom descriptif</th>
          <th>Prix public (fcfa)</th>
          <th>Litrage</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($prods as $prod): ?>
          <tr>
            <td><?php echo htmlspecialchars($prod['id_produit']); ?></td>
            <td><?php echo htmlspecialchars($prod['nom_commercial']); ?></td>
            <td><?php echo htmlspecialchars($prod['nom_descriptif']); ?></td>
            <td><?php echo htmlspecialchars($prod['prix']); ?></td>
            <td><?php echo htmlspecialchars($prod['poids']); ?></td>
            <td>
              <button class="edit-btn" onclick="openEditModalProduit('<?php echo $prod['id_produit']; ?>','<?php echo $prod['nom_commercial']; ?>', '<?php echo $prod['nom_descriptif']; ?>', '<?php echo $prod['prix']; ?>', '<?php echo $prod['poids']; ?>')">Éditer</button>
              <button class="delete-btn" onclick="openDeleteModal('<?php echo $prod['id_produit']; ?>')">Supprimer</button>
            </td>
          </tr>
        <?php endforeach; ?>
        <!-- Ajouter d'autres lignes pour chaque Produit -->
      </tbody>
    </table>
  </div>
  </div>
</main>


<div id="productModal" class="modal">
  <div class="modal-content">
    <span class="close-button" onclick="closeModal()">&times;</span>
    <h2 id="modalTitle">Ajouter un produit</h2>
    
    <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
    <form method="POST" action="../includes/classes/produit_method/create_product.php"  class="form-col">
      <!-- Champ caché pour identifier l'édition d'un produit -->
      <input type="hidden" name="product_id" id="product_id">
      <div>
        <label for="nom_commercial">Nom Commercial</label>
        <input required="" id="commercialName" name="nom_commercial" type="text" class="form-input-text" placeholder="Nom Commercial du produit ...">
      </div>
      
      <div>
      <label for="nom_descriptif">Noms Descriptif</label>
      <input required="" id="descripName" name="nom_descriptif" type="text" class="form-input-text" placeholder="Nom Descriptif...">
      </div>
      <div>
          <label for="prix">Prix Unitaire(Fcfa)</label>
          <input required="" id="prix" name="prix" type="number">
      </div>
      <div>
          <label for="store">Litrage</label>
          <select name="poids" id="store" required>
                        <option value="">Sélectionnez l'unite de mesure</option>
                            <optgroup label="Litre">
                                <option value="250ml">250ml</option>
                                <option value="1L">1L</option>
                                <option value="5L">5L</option>

                            </optgroup>
                            <optgroup label="Gramme">
                                <option value="250g">250g</option>
                                <option value="220g">220g</option>
                                <option value="200g">200g</option>
                                <option value="125g">125g</option>
                                <option value="50g">50g</option>
                                <option value="600g">600g</option>
                            </optgroup>
                        </select> 
                    </div>   
      <!-- Bouton Ajouter en bas -->
      <button type="submit" class="add-button" >Ajouter</button>
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

    <form method="POST" action="../includes/classes/produit_method/delete_product.php" class="btn-container-val">
        <!-- Champ caché pour identifier l'édition d'un produit--> 
        <input type="hidden" name="product_id" id="delete_product_id">
        <button type="submit" id="delete"class="add-button">Supprimer</button> <?php //buton qui vas executer la fonction delete?>
        <button class="add-button" onclick="closeModalValidation()">Non</button>
    </form>

  </div>
</div>

<?php include("../includes/footer.php"); ?>
