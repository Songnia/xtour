<?php 
$titre = "Livraison"; 

session_start();



switch($_SESSION['role']) {/*'Admin', 'Commercial', 'responsable_commercia...	*/
  case 'Admin': 
    include_once("../includes/sidebar-mobile.php");
    include_once("../includes/sidebar.php");
    break;

  default:
  include_once("../includes/sidebar-com.php");
}

// Insérer le header
include("../includes/header.php");

//include("../includes/config.php");

include_once("../includes/classes/Database.php");
include_once("../includes/classes/Livraison.php");
include_once("../includes/classes/Magasin.php");
include_once("../includes/classes/Produit.php");




$database = new Database();
$db = $database->getConnection();
$livraison = new Livraison($db);

// Lecture des produits
$livs = $livraison->read();
$produit = new Produit($db);
$magasin = new Magasin($db);

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

    <!-- Filtre Par Livraison -->
    <div class="divFilter">
        <label for="filter_livraison">Par Livraison :</label>
        <div class="radio-inputs">
            <label class="radio" for="livraison1">
                <input id="livraison1" type="radio" name="radio_livraison" value="livraison1" checked="">
                <span class="name">Livraison1</span>
            </label>
            <label class="radio" for="livraison2">
                <input id="livraison2" type="radio" name="radio_livraison" value="livraison2">
                <span class="name">Livraison2</span>
            </label>
            <label class="radio" for="livraison3">
                <input id="livraison3" type="radio" name="radio_livraison" value="livraison3">
                <span class="name">Livraison3</span>
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
          <th>code</th>
          <th>Ville</th>
          <th>Magasin</th>
          <th>Produit</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($livs as $liv): ?>
          <tr>
          <td><?php echo htmlspecialchars( $liv['id_livraison']); ?></td>
            <td><?php echo htmlspecialchars($liv['code']); ?></td>
            <td><?php echo htmlspecialchars($liv['ville']); ?></td>
            <td>
              <?php 
                  $name_magasin = $magasin->getNameMagasin($liv['magasin_id']);
                  echo htmlspecialchars($name_magasin);
              ?>
            </td>
            <td>
              <table>
                  <thead>
                      <tr>
                        <th>Nom</th>
                        <th>Quantite</th>
                        <th>Date</th>
                      </tr>
                  </thead>
                  <?php $prodsM = $livraison->getProduit( $liv['id_livraison'] );?>
                  
                  <tbody>
                    <?php foreach($prodsM as $prodm){ ?>
                        <tr onclick="openModalProduitMagasin('<?php echo $liv['id_livraison']; ?>')">
                            <td>
                              <?php 
                                  $name_produit = $produit->getNameProduit($prodm['produit_id']);
                                  echo $name_produit;
                              ?>
                            </td>
                            <td><?php echo htmlspecialchars($prodm['quantite']); ?></td>
                            <td><?php echo "Fab: ". htmlspecialchars($prodm['date_fabrication'])."    Exp: ". htmlspecialchars($prodm['date_expiration']); ?></td>
                        </tr>
                     <?php } ?> 
                  </tbody>
              </table>
            </td>

            <td>
              <!--<button class="edit-btn" onclick="openEditModalLivraison('<?php echo $liv['id_livraison']; ?>','<?php echo $liv['nom_commercial']; ?>', '<?php echo $liv['nom_descriptif']; ?>', '<?php echo $liv['prix']; ?>', '<?php echo $liv['poids']; ?>')">Éditer</button>
              <button class="delete-btn" onclick="openDeleteModal('<?php echo $liv['id_livraison']; ?>')">Supprimer</button>-->
              <button class="edit-btn" onclick="openModalProduitMagasin('<?php echo $liv['id_livraison']; ?>')">Ajouter un produit</button>
            </td>
          </tr>
        <?php endforeach; ?>
        <!-- Ajouter d'autres lignes pour chaque Livraison -->
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
    <form method="POST" action="../includes/classes/livraison_method/create_livraison.php"  class="form-col">
      <!-- Champ caché pour identifier l'édition d'un livraison -->
      <input type="hidden" name="livraison_id" id="livraison_id">
      <div>
          <label for="Ville">Ville</label>
            <select name="ville" id="type">
              <option value="Douala">Douala</option>
              <option value="Yaounde">Yaounde</option>
              <!-- Autres options ici -->
            </select>
      </div> 
      <?php 
          try{
              $query = "SELECT * FROM Magasin ORDER BY date_enregistrement DESC";
              $stmt = $db->prepare($query);
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          } catch (Exception $e) {
                                // Annuler la transaction en cas d'erreur
                                $db->rollBack();
                                error_log($e->getMessage());
                                echo "Erreur capturée : " . $e->getMessage();
                                return false;
          }                                    
      ?>
      
      <div>
          <select name="nom_magasin" id="nom_magasin">
                            <option value="">Nom du magasin</option>
                            <?php foreach($result as $res): ?>
                                <option value="<?php echo htmlspecialchars($res['id_magasin']); ?>" <?php if ($nom == $res['nom']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($res['nom']); ?>
                                </option>
                            <?php endforeach; ?>
          </select>
      </div>
        <?php
          $prods = $produit->read();
        ?>
      <div>
          <label for="store">Produit</label>
          <select name="produit" id="">
          <?php 
            foreach ($prods as $prod) { ?>
              <option value="<?php echo $prod['id_produit']; ?>">
                  <?php echo $prod['nom_commercial']; ?>
              </option>
            <?php }  
          ?>
          </select>         
      </div>   
      <div>
          <label for="Quantite">Quantite</label>
          <input required="" id="quantite" name="quantite" type="number">
      </div>
      <div class="stock-info" class="question">
          <div class="infoProduit">
                                <label for="dateFab">Date de fabrication</label>
                                <input type="date" id="dateFab" name="dateFab" >
          </div>
          <div class="infoProduit">
                                <label for="dateExp">Date d'expiration</label>
                                <input type="date" id="dateExp" name="dateExp" >
          </div>
      </div>      
      <!-- Bouton Ajouter en bas -->
       <div class="infoPMagasin">
            <button type="submit" class="add-button" >Ajouter</button>
       </div>
      
    </form>


  </div>
</div>

<div id="productModal2" class="modal">
  <div class="scroll-y" style="overflow-y: auto;max-height: 550px;">
      <!--<div class="modal-content">
          <span class="close-button2" onclick="closeModal()">&times;</span>
          <h2>Ajouter un Produit</h2>
          <div class="form-col">
              <div class="my-form-container">
                  <form class="my-form" method="POST" action="../includes/classes/livraison_method/addProduit_livraison.php">
                      <input type="hidden" id="id_magasinproduit" name="id_magasin" >
                      <input type="hidden" id="id_livraison" name="id_livraison" >

                      <?php $i = 0; ?>
                      <h3>Sélectionnez les produits :</h3>
                      <?php foreach($prods as $prod): ?>
                        <div class="infoPMagasin" style="margin:0">
                            <div class="infoPMagasin" style="">
                                <input id="product<?php echo ++$i; ?>" type="checkbox" name="products[]" value="<?php echo htmlspecialchars($prod['nom_commercial']); ?>">
                                <label for="product<?php echo $i; ?>"><?php echo htmlspecialchars($prod['nom_commercial']); ?></label>
                            </div>
                            <input type="number" name="quantity_product[]" id="" style="width:100px">
                        </div>
                        <div class="stock-info" class="question">
                            <div class="infoProduit">
                                <label for="dateFab">Date de fabrication</label>
                                <input type="date" id="dateFab" name="dateFab" >
                            </div>
                            <div class="infoProduit">
                                <label for="dateExp">Date d'expiration</label>
                                <input type="date" id="dateExp" name="dateExp" >
                            </div>
                        </div>

                      <?php endforeach; ?>
                      <button type="submit" class="add-button">Ajouter</button>
                  </form>
              </div>
      

          </div>
      </div>-->
    
  <div class="modal-content">
    <span class="close-button" onclick="closeModal()">&times;</span>
    <h2 id="modalTitleLiv">Ajouter une Livraison</h2>
    
    <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
    <form method="POST" action="../includes/classes/livraison_method/addProduit_livraison.php"  class="form-col">
      <!-- Champ caché pour identifier l'édition d'un livraison -->
      <input type="hidden" name="livraison_id" id="id_livraison_form">   
        <?php
          $prods = $produit->read();
        ?>
      <div>
          <label for="store">Produit</label>
          <select name="produit" id="">
          <?php 
            foreach ($prods as $prod) { ?>
              <option value="<?php echo $prod['id_produit']; ?>">
                  <?php echo $prod['nom_commercial']; ?>
              </option>
            <?php }  
          ?>
          </select>         
      </div>   
      <div>
          <label for="Quantite">Quantite</label>
          <input required="" id="quantite" name="quantite" type="number">
      </div>
      <div class="stock-info" class="question">
          <div class="infoProduit">
                                <label for="dateFab">Date de fabrication</label>
                                <input type="date" id="dateFab" name="dateFab" >
          </div>
          <div class="infoProduit">
                                <label for="dateExp">Date d'expiration</label>
                                <input type="date" id="dateExp" name="dateExp" >
          </div>
      </div>      
      <!-- Bouton Ajouter en bas -->
       <div class="infoPMagasin">
            <button type="submit" class="add-button" >Ajouter</button>
       </div>
      
    </form>


  </div>
    </div>

</div> 

<?php include("../includes/footer.php"); ?>
