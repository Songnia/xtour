<?php 
$titre = "Magasins"; 
include_once("../includes/sidebar-mobile.php");

// Insérer le header
include_once("../includes/header.php");

// Insérer la Sidebar
include_once("../includes/sidebar.php");
include_once("../includes/classes/Database.php");
include_once("../includes/classes/Magasin.php");
include_once("../includes/classes/Produit.php");


$database = new Database();
$db = $database->getConnection();
$magasin = new Magasin($db);
$produit = new Produit($db);

$prods = $produit->read();
$magas= $magasin->read();


/*$contacts = $magasin->readContact($maga['id_magasin']);

echo "<pre>";
    var_dump($contacts);
    
echo "</pre>";*/

?>


<div class="page-container">
    <div class="content-header">
        <h1 id="alpha">Magasins</h1>
    </div>
    <style>
    .radio-inputs {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        border-radius: 0.5rem;
        background-color: #EEE;
        box-sizing: border-box;
        box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
        padding: 0.20rem;
        width: 200px;
        font-size: 12px;
        }

    .radio-inputs .radio {
        flex: 1 1 auto;
        text-align: center;
        }

    .radio-inputs .radio input {
        display: none;
        }

    .radio-inputs .radio .name {
        display: flex;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        border: none;
        padding: .5rem 0;
        color: rgba(51, 65, 85, 1);
        transition: all .15s ease-in-out;
        }

    .radio-inputs .radio input:checked + .name {
        background-color: #fff;
        font-weight: 600;
        }
    #h3-inline{
        display: flex;
        align-items: center;
        gap:10px;
    }
    .content-body{
        display: none;
    }
    .container-scroll{
        display: block;
    }

    .img-map{
        width: 45px;
        height: 45px;
        border-radius: 100px;
        border: 2px solid yellow;

    }
    #la-map{
        padding-left:4% ;
    }
    #hiddetr tr{
        display: none;
    }

    </style>
    <div class="page-controls">
            <div id="h3-inline"> <h3 id="maga-h3">Magasins</h3> 
                <div class="radio-inputs">
                <label class="radio" onclick="showList()">
                    <input id="liste" type="radio" name="radio" checked="">
                    <span class="name">Liste</span>
                </label>
                <label class="radio" onclick="showDetail()">
                    <input id="detail" type="radio" name="radio">
                    <span class="name">plus de detaille</span>
                </label>
                </div>
            </div>
            <div id="filterContainer" class="filter-container">
                <div id="selectedFilters" class="selected-filters">
                <!-- Les tags sélectionnés s'afficheront ici -->
                    <div class="group1">
                        <input type="text" placeholder="Rechercher" class="search-store" id="searchInput">
                        <svg id="go" class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
                    </div>
                </div>
            </div>
            <div class="sort-filter">
                <button id="addButton" class="btn btn-green">Ajouter Magasin</button>
            </div>
    </div>
    <div id="containterFilter">
        <div id="elementsFilter">
        <div class="close-containerFilter" onclick="closeFilterContainer()"> &times;</div>
            <div class="divFilter">
                <label for="filter_magasin">Par Magasin :</label>
                <div class="radio-inputs">
                    <label class="radio">
                        <input id="magasin1" type="radio" name="radio_magasin" value="Magasin1">
                        <span class="name">Magasin1</span>
                    </label>
                    <label class="radio">
                        <input id="magasin2" type="radio" name="radio_magasin" value="Magasin2">
                        <span class="name">Magasin2</span>
                    </label>
                </div>
            </div>

            <div class="divFilter">
                <label for="filter_produit">Par Produit :</label>
                <div class="radio-inputs">
                    <label class="radio">
                        <input id="produit1" type="radio" name="radio_produit" value="Produit1">
                        <span class="name">Produit1</span>
                    </label>
                    <label class="radio">
                        <input id="produit2" type="radio" name="radio_produit" value="Produit2">
                        <span class="name">Produit2</span>
                    </label>
                </div>
            </div>

            <div class="divFilter">
                <label for="filter_date">Par Date :</label>
                <div class="radio-inputs">
                    <label class="radio">
                        <input id="recent" type="radio" name="radio_date" value="Plus récent d'abord">
                        <span class="name">Plus récent d'abord</span>
                    </label>
                    <label class="radio">
                        <input id="moins_recent" type="radio" name="radio_date" value="Moins récent d'abord">
                        <span class="name">Moins récent d'abord</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <style>
                .info_livraison{
                    background-color: #adadadbf;
                    color: #242323;
                    padding: 3px 0px 3px 3px;
                    margin-right: 5px;
                    border-radius: 5px;
                    font-style: italic;
                }
    </style>

    <div class="content-body">
        <?php foreach ($magas as $maga): ?>
            <div class="elementsBody">
                    <div class="store-info">
                        <h4><?php echo htmlspecialchars($maga['nom']); ?></h4>
                        <p>Dernière Livraison: <span id="iii">--date--</span></p>
                        <div class="product-list">
                        <!--<button  class="addButton2 btn btn-purple" onclick="openEditModalMagasin('<?php echo $maga['id_magasin']; ?>',
                                                                                                  <?php echo $maga['ville']; ?>, 
                                                                                                  <?php echo $maga['nom']; ?>',
                                                                                                  <?php echo $maga['type']; ?>', 
                                                                                                  <?php echo $maga['name']; ?>', 
                                                                                                  <?php echo $maga['phone']; ?>', 
                                                                                                  <?php echo $maga['relation']; ?>')">
                        Modifier</button>-->                        
                        <button  class=" btn btn-purple" onclick="openAddModalContact('<?php echo $maga['id_magasin']; ?>')">Ajouter un contact</button>
                        <button  class=" btn btn-purple" onclick="openEditModalMagasin('<?php echo $maga['id_magasin']; ?>')">Modifier</button>
                        <button  class="addButton2 btn btn-green" onclick="openModalProduitMagasin('<?php echo $maga['id_magasin']; ?>')">Ajouter un produit</button>

                    </div>
                    </div>
                    <?php $prodsM = $magasin->getProduit( $maga['id_magasin'] );?>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Noms Produit</th>
                                <th>Qt en stock</th>
                                <th>Qt en rayon</th>
                                <th>Derniere Livraison</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($prodsM as $prodm){ ?>                           
                                <tr>
                                    <td><?php echo htmlspecialchars($prodm['produit']); ?></td>
                                    <td><?php echo htmlspecialchars($prodm['quantite_stock']); ?></td>
                                    <td><?php echo htmlspecialchars($prodm['quantite_rayon']); ?></td>
                                    <td>
                                        <div>
                                            <span class="info_livraison">Date:</span> <span> 20/20/2020</span>
                                            <span class="info_livraison">Quantite:</span> <span> 20</span>
                                        </div>
                                    </td>
                                    <td>
                                    <button class="delete-btn" onclick="openMDeleteModal('<?php echo $prodm['id_produit']; ?>')">Supprimer</button>
                                    </td>
                                </tr>  
                            <?php }?>
                            <!-- Ajoutez d'autres lignes ici si nécessaire -->
                        </tbody>
                    </table>
                
            </div>
        <?php endforeach; ?>
    </div>            


    <!-- Stores Table --> 
    <div class="container-scroll">
        <div class="table-section">
        <table>
        <thead>
            <tr>
            <th>ID</th>
            <th>Ville</th>
            <th>Nom magasin</th>
            <th>Localisation</th>
            <th>Nos contacts</th>
            <th>Type</th>
            <th>Produit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($magas as $maga): ?>
            <tr>
                <td><?php echo htmlspecialchars($maga['id_magasin']); ?></td>
                <td><?php echo  htmlspecialchars($maga['ville']); ?></td>
                <td><?php echo htmlspecialchars($maga['nom']); ?></td>
                <td id="la-map">
                    <a href="<?php echo "https://www.google.com/maps?q=" . htmlspecialchars($maga['latitude']) . "," . htmlspecialchars($maga['longitude']); ?>" target="_blank">
                        <img class="img-map" src="../assets/map.webp" alt="Voir l'emplacement sur Google Maps">
                    </a>
                </td>
                <td>
                            <table class="tableContact" >
                                <thead onclick="settrblock()">
                                    <th>name</th>
                                    <th>phone</th>
                                </thead>
                                <tbody id="hiddetr">
                                    <?php
                                        $contacts = $magasin->readContact($maga['id_magasin']);
                                        foreach ($contacts as $contact){ ?>
                                        <tr id="trblock">
                                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                 </td>
                <td><?php echo htmlspecialchars($maga['type']); ?></td>
                <td>
                    <?php $prodsM = $magasin->getProduit( $maga['id_magasin'] );
                        foreach($prodsM as $prodm){
                            echo $prodm['produit'].", ";
                        }
                    ?>

                </td>
            </tr>
            <?php endforeach; ?>
            <!-- Ajouter d'autres lignes pour chaque Produit -->
        </tbody>
        </table>
    </div>
    </div>
</div>
<!-- Pop-up Modal add magasin -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <h2>Ajouter un Magasin</h2>
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <form method="POST" action="../includes/classes/magasin_method/create_magasin.php" class="form-col">
        <input type="hidden" id="id_magasin" name="id_magasin" >

            <div class="infoPMagasin">
                    <div>
                        <label for="Ville"></label>
                            <select name="ville" id="type">
                                <option value="">Ville</option>
                                <option value="Douala">Douala</option>
                                <option value="Yaounde">Yaounde</option>
                            <!-- Autres options ici -->
                            </select>
                    </div>
                    <div>
                        <input type="text" name="nom" id="store" placeholder="Nom du magasin" >
                    </div>                              
            </div>
            <div class="infoPMagasin">
                <div>
                        <select name="type" id="type">
                            <option value="">Type de Magasin</option>
                            <option value="Super Marché">Supermarché</option>
                            <option value="Magasin Made in Cameroun">Magasin Made in Cameroun</option>
                            <option value="Supérette">Supérette</option>
                            <option value="Autre">Autre</option>
                        <!-- Autres options ici -->
                        </select>
                </div>                  
            </div>
            <hr> <br>
            <label for="" style="font-style:italic;font-weight:bold;font-size:larger;">Nos Contact Dans le magasin</label>
            <div>
                    <div class="infoPMagasin">
                        <div>
                            <label for="chefMagasinName">Nom</label>
                            <input required="" id="" name="name" type="text" placeholder="nom ...">
                        </div>
                        <div>
                            <label for="contactChef">Telephone</label>
                            <input required="" id="contactChef" name="phone" type="tel" placeholder="+237 6********">
                        </div>
                        <div class="infoPMagasinName">
                                <input id="Latitude" name="latitude" type="hidden" placeholder="6.521..">
                                <input id="Longitude" name="longitude" type="hidden" placeholder="4.658...">
                        </div>
                    </div>
                    <div class="my-form">
                        <div class="choix">
                            <input type="checkbox" name="relation[]" value="Il connais notre commercial" >
                            <label for="commercialKnow">Connait-il notre commercial ?</label>
                        </div>
                        <div class="choix">
                            <input type="checkbox" name="relation[]" value="Il connais nos produits">
                            <label for="produitKnow">Connait-il nos produits ?</label>
                        </div>

                        <div class="infoPMagasin">                        
                            <label for="relation">Notre relation</label>
                            <select name="relation[]" style="width:400px">
                                <option value="Supportaire">Supportaire</option>
                                <option value="Neutre">Neutre</option>
                                <option value="Contre nous">Contre nous</option>
                            </select>
                        </div>
                        <div class="choix">
                            <input type="checkbox" name ="relation[]" value="Honette" id="">
                            <label for="Honette">Il est Honnette</label>
                        </div>
                    </div>     
            </div>

            <button type="submit" class="add-button" >Ajouter</button>
        </form>
    </div>
</div>  

<div id="contactModal" class="modal">
<div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <h2>Ajouter un Contact</h2>
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <form method="POST" action="../includes/classes/magasin_method/updateMagasin.php" class="form-col">
        <input type="hidden" id="id_magasin_contact" name="id_magasin" >
            <hr> <br>
            <label for="" style="font-style:italic;font-weight:bold;font-size:larger;">Nos Contact Dans le magasin</label>
            <div>
                    <div class="infoPMagasin">
                        <div>
                            <label for="chefMagasinName">Nom</label>
                            <input required="" id="" name="name" type="text" placeholder="nom ...">
                        </div>
                        <div>
                            <label for="contactChef">Telephone</label>
                            <input required="" id="contactChef" name="phone" type="tel" placeholder="+237 6********">
                        </div>
                    </div>
                    <div class="my-form">
                        <div class="choix">
                            <input type="checkbox" name="relation[]" value="1" >
                            <label for="commercialKnow">Connait-il notre commercial ?</label>
                        </div>
                        <div class="choix">
                            <input type="checkbox" name="relation[]" value="2">
                            <label for="produitKnow">Connait-il nos produits ?</label>
                        </div>

                        <div class="infoPMagasin">                        
                            <label for="relation">Notre relation</label>
                            <select name="relation[]" style="width:400px">
                                <option value="3">Supportaire</option>
                                <option value="4">Neutre</option>
                                <option value="5">Contre nous</option>
                            </select>
                        </div>
                        <div class="choix">
                            <input type="checkbox" name ="relation[]" value="6" id="">
                            <label for="Honette">Il est Honnette</label>
                        </div>
                    </div>     
            </div>

            <button type="submit" class="add-button" >Ajouter</button>
        </form>
    </div>
</div>

<div id="productModal2" class="modal">
    <div class="modal-content">
        <span class="close-button2" onclick="closeModal()">&times;</span>
        <h2>Ajouter un Produit</h2>
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <div class="form-col">
            <div class="my-form-container">
                <form class="my-form" method="POST" action="../includes/classes/magasin_method/addProduit_magasin.php">
                    <!-- Champ caché pour transmettre l'ID du magasin -->
                    <input type="hidden" id="id_magasinproduit" name="id_magasin" >
                    <?php $i = 0; ?>
                    <h3>Sélectionnez les produits :</h3>
                    <?php foreach($prods as $prod): ?>
                        <div>
                            <input id="product<?php echo ++$i; ?>" type="checkbox" name="products[]" value="<?php echo htmlspecialchars($prod['nom_commercial']); ?>">
                            <label for="product<?php echo $i; ?>"><?php echo htmlspecialchars($prod['nom_commercial']); ?></label>
                        </div>
                    <?php endforeach; ?>
                    <!-- Bouton de soumission -->
                    <button type="submit" class="add-button">Ajouter</button>
                </form>
                <!-- Autres options ici -->
            </div>
    

        </div>
    </div>
</div>  
<div id="modal3" class="modal">
  <div class="modal-content validationModal">
    <span class="close-button" onclick="closeModalValidation()">&times;</span>
    <div class="image">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
    </div>
    Confirmer la supression!
    <!-- Bouton Ajouter en bas -->

    <form method="POST" action="../includes/classes/magasin_method/delete_produitM.php" class="btn-container-val">
        <!-- Champ caché pour identifier l'édition d'un produit--> 
        <input type="hidden" name="product_id" id="delete_productM_id" value="<?php echo  $prodm['id_produit']; ?>">
        <button type="submit" id="delete"class="add-button">Supprimer</button> <?php //buton qui vas executer la fonction delete?>
        <button class="add-button" onclick="closeModalValidation()">Non</button>
    </form>

  </div>
</div>

<?php include_once("../includes/footer.php"); ?>