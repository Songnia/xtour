<?php

$titre = "produit";
include("../includes/sidebar-mobile.php");

//Inserer le header
include("../includes/header.php");

// Inserer la Sidebar
include("../includes/sidebar.php");
include("../includes/config.php");
echo "Hello";
//include("../includes/classes/produit_method/read_product.php");


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
    <input type="text" placeholder="Rechercher un Produit..." class="search-store">
    <button id="addButton" class="add-store-btn" onclick="openModalProduit()">Ajouter un Produit</button>
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
      <?php foreach($prods as $prod): ?>
        <tr>
          <td><?php echo htmlspecialchars($prod['id_produit']); ?></td>
          <td><?php echo htmlspecialchars($prod['nom_commercial']); ?></td>
          <td><?php echo htmlspecialchars($prod['nom_descriptif']); ?></td>
          <td><?php echo htmlspecialchars($prod['prix']); ?></td>
          <td><?php echo htmlspecialchars($prod['poids']); ?></td>
          <td>
      <!-- ❌❌❌❌❌❌❌❌UPDATE NE FONCTIONNE PAS ENCORE CORRECTEMENT❌❌❌❌❌❌❌❌❌❌❌❌❌❌ -->
            <button class="edit-btn" onclick="openEditModalProduit('<?php echo $prod['id_produit']; ?>','<?php echo $prod['nom_commercial']; ?>', '<?php echo $prod['nom_descriptif']; ?>', '<?php echo $prod['prix']; ?>', '<?php echo $prod['poids']; ?>')">Éditer</button>
            <button class="delete-btn">Supprimer</button>
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
        <input id="commercialName" name="nom_commercial" type="text" class="form-input-text" placeholder="Noms Commercial...">
      </div>
      
      <div>
      <label for="nom_descriptif">Noms Descriptif</label>
      <input id="descripName" name="nom_descriptif" type="text" class="form-input-text" placeholder="Noms Descriptif...">
      </div>
      <div>
          <label for="prix">Prix(Fcfa)</label>
          <input id="prix" name="prix" type="number">
      </div>
      <div>
          <label for="poids">Poids(l/g)</label>
          <input id="poids" name="poids" type="number">
      </div>
      <!-- Bouton Ajouter en bas -->
      <button type="submit" class="add-button">Ajouter</button>
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
