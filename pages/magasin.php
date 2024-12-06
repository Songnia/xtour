<?php 
$titre = "Magasins"; 
include_once("../includes/sidebar-mobile.php");

// Insérer le header
include_once("../includes/header.php");

// Insérer la Sidebar
include_once("../includes/sidebar.php");
include_once("../includes/classes/Database.php");
include_once("../includes/classes/Magasin.php");

$database = new Database();
$db = $database->getConnection();
$magasin = new Magasin($db);

$magas= $magasin->read();
?>


<div class="page-container">
    <div class="content-header">
        <h1>Magasins</h1>
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
                <span>Trier par:</span>
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

    <div class="content-body">
        <div class="store-info">
            <h4>Nom du Magasin</h4>
            <p>Dernière Livraison: <span>--date--</span></p>
            <div class="product-list">
                <button  class="addButton2 btn btn-green" onclick="openModalProduitMagasin()">Ajouter un produit</button>
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
        <table class="product-table">
            <thead>
                <tr>
                    <th>Noms Produit</th>
                    <th>Qt en stock</th>
                    <th>Qt en rayon</th>
                    <th>Derniere Livraison</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($magas as $maga): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($maga['id_magasin']); ?></td>
                        <td>10</td>
                        <td>5</td>
                        <td>
                            <div>
                                <span class="info_livraison">Date:</span> <span> 20/20/2020</span>
                                <span class="info_livraison">Quantite:</span> <span> 20</span>
                            </div>
                        </td>
                    </tr>  
                <?php endforeach; ?>
                <!-- Ajoutez d'autres lignes ici si nécessaire -->
            </tbody>
        </table>
    </div>
    <!-- Stores Table --> 
    <div class="container-scroll">
        <div class="table-section">
        <table>
        <thead>
            <tr>
            <th>ID</th>
            <th>Nom magasin</th>
            <th>Localisation</th>
            <th>Chef du magasin</th>
            <th>Nos contacts</th>
            <th>Type</th>
            <th>Produit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($magas as $maga): ?>
            <tr>
                <td><?php echo htmlspecialchars($maga['id_magasin']); ?></td>
                <td><?php echo htmlspecialchars($maga['nom']); ?></td>
                <td><?php echo htmlspecialchars($maga['localisation']); ?></td>
                <td><?php echo htmlspecialchars($maga['chef_magasin']); ?></td>
                <td><?php echo htmlspecialchars($maga['contacts']); ?></td>
                <td><?php echo htmlspecialchars($maga['type']); ?></td>
                <td>Kara, Sable, Apero</td>
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
            <div class="infoPMagasin">
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
            <div class="infoPMagasin">
                    <div>
                        <label for="chefMagasinName">Nom du chef de magasin</label>
                        <input required="" id="chefMagasinName" name="chefMagasinName" type="text" placeholder="chef magasint ...">
                    </div>
                    <div>
                        <label for="contactChef">Contact</label>
                        <input required="" id="contactChef" name="contactChef" type="tel" placeholder="+237 6********">
                    </div>
            </div>
            <div class="infoPMagasin">
                    <div>
                        <label for="contactName1">Nom du chef de magasin</label>
                        <input required="" id="contactName1" name="contactName1" type="text" placeholder="chef magasint ...">
                    </div>
                    <div>
                        <label for="contact1">Contact1</label>
                        <input required="" id="contact1" name="contact1" type="tel" placeholder="+237 6********">
                    </div>
            </div> 
            <div class="infoPMagasin">
                    <div>
                        <label for="contactName2">Nom du chef de magasin</label>
                        <input  id="contactName2" name="contactName2" type="text" placeholder="chef magasint ...">
                    </div>
                    <div>
                        <label for="contact2">Contact2</label>
                        <input  id="contact2" name="contact2" type="tel" placeholder="+237 6********">
                    </div>
            </div>      
            <div class="infoPMagasin">
                    <div>
                        <label for="contactName3">Nom du chef de magasin</label>
                        <input id="contactName3" name="contactName3" type="text" placeholder="chef magasint ...">
                    </div>
                    <div>
                        <label for="contact3">Contact3</label>
                        <input  id="contact3" name="contact3" type="tel" placeholder="+237 6********">
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
                    <input type="hidden" name="id_magasin" value="1">

                    <h3>Sélectionnez les produits :</h3>
                    <div>
                        <input id="product1" type="checkbox" name="products[]" value="Kara">
                        <label for="product1">Produit 1</label>
                    </div>
                    <div>
                        <input id="product2" type="checkbox" name="products[]" value="Cookies">
                        <label for="product2">Produit 2</label>
                    </div>
                    <div>
                        <input id="product3" type="checkbox" name="products[]" value="Sable">
                        <label for="product3">Produit 3</label>
                    </div>
                    <!-- Bouton de soumission -->
                    <button type="submit" class="add-button">Ajouter</button>
                </form>
                <!-- Autres options ici -->
            </div>
    

        </div>
    </div>
</div>  


<?php include_once("../includes/footer.php"); ?>
