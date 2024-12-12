<?php 
$titre = "Magasins"; 
include_once("../includes/sidebar-mobile.php");

// Insérer le header
include_once("../includes/header.php");

// Insérer la Sidebar
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<main class="main-content1">  
  <!-- Page Title -->
  <div class="page-title">
    <h1>Livraison</h1>
  </div>
  
  <!-- Search and Add New Store -->
  <div class="store-actions">
    <div class="group1" style="width: 80%">
        <input type="text" placeholder="Rechercher" class="search-store" id="searchInput"  >
        <svg id="go" class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
    </div>
    <button id="addButton" class="add-store-btn" onclick="openModalLivraison()">Nouvelle Livraison</button>
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
          <th>Ville</th>
          <th>Magasin</th>
          <th>Produit</th>
          <th>Quantite</th>
          <th>Prix</th>
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
    <h2 id="modalTitle">Ajouter une Livraison</h2>
    
    <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
    <form method="POST" action="../includes/classes/produit_method/create_product.php"  class="form-col">
      <!-- Champ caché pour identifier l'édition d'un produit -->
      <input type="hidden" name="product_id" id="product_id">
      <div class="infoPMagasin" >
                    <div>
                        <label for="store">Magasin</label>
                        <select name="nom" id="store">
                        <option value="">Sélectionnez un magasin</option>
                            <optgroup label="Douala">
                                <option value="santa-lucia-akwa">Santa Lucia Akwa</option>
                                <option value="santa-lucia-a-nord">Santa Lucia A Nord</option>
                                <option value="santa-lucia-bberi">Santa Lucia Bberi</option>
                                <option value="santa-lucia-bssadi">Santa Lucia Bssadi</option>
                                <option value="santa-lucia-c-cicam">Santa Lucia C Cicam</option>
                                <option value="santa-lucia-nkolbong">Santa Lucia Nkolbong</option>
                                <option value="santa-lucia-palmier">Santa Lucia Palmier</option>
                                <option value="santa-lucia-dla-bercy">Santa Lucia Dla-Bercy</option>
                                <option value="ma-sarl-douala">Ma Sarl Douala</option>
                                <option value="paul-gaby-sarl">Paul Gaby Sarl</option>
                                <option value="vinny-akwa-1">Vinny Akwa 1</option>
                                <option value="vinny-akwa-2">Vinny Akwa 2</option>
                                <option value="mahima-bssadi">Mahima Bssadi</option>
                                <option value="mahima-akwa">Mahima Akwa</option>
                                <option value="fortune-cosmetics">Fortune cosmetics</option>
                                <option value="parfumerie-jp">Parfumerie JP</option>
                                <option value="precision-pressing">Precision Pressing</option>
                            </optgroup>
                            <optgroup label="Yaoundé">
                                <option value="mieux-vivre">Mieux Vivre</option>
                                <option value="sesame-market">Sesame Market</option>
                                <option value="vitrine-du-cameroun-yde">Vitrine du Cameroun Yde</option>
                                <option value="vitalia">Vitalia</option>
                                <option value="ma-sarl-tsinga">Ma Sarl Tsinga</option>
                                <option value="ma-sarl-mvolye">Ma Sarl Mvolye</option>
                                <option value="ma-min-commerce">Ma Min Commerce</option>
                                <option value="ma-bastos">Ma Bastos</option>
                                <option value="la-sama">La Sama</right>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label for="typeMagasin">Type de Magasin</label>
                        <select name="type" id="type">
                            <option value="Supermarché">Supermarché</option>
                            <option value="Magasin Made in Cameroun">Magasin Made in Cameroun</option>
                            <option value="Supérette">Supérette</option>
                            <option value="Autre">Autre</option>
                        <!-- Autres options ici -->
                        </select>
                    </div>           
      </div>
      <div>
          <label for="Ville">Ville</label>
            <select name="type" id="type">
              <option value="Douala">Douala</option>
              <option value="Yaounde">Yaounde</option>
              <!-- Autres options ici -->
            </select>
      </div> 
      <div>
          <label for="store">Produit</label>
          <select name="prosuit" id="store" required>
            <option value="Kara">Kara</option>
            <option value="Cookies">Cookies</option>
          </select> 
      </div>   
      <div>
          <label for="Quantite">Quantite</label>
          <input required="" id="quantite" name="quantite" type="number">
      </div>
      <div>
          <label for="prix">Prix Unitaire(Fcfa)</label>
          <input required="" id="prix" name="prix" type="number">
      </div> 
      <!-- Bouton Ajouter en bas -->
      <button type="submit" class="add-button" >Ajouter</button>
    </form>


  </div>
</div>

<?php include("../includes/footer.php"); ?>
