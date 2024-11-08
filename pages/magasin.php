<?php 
$titre = "Magasins"; 
include_once("../includes/sidebar-mobile.php");

// Insérer le header
include_once("../includes/header.php");

// Insérer la Sidebar
include_once("../includes/sidebar.php");
?>


<div class="page-container">
    <div class="content-header">
        <h1>Magasins</h1>
    </div>

    <div class="content-body">
        <div class="page-controls">
            <h3>Magasins</h3>
            <div class="sort-filter">
                <span>Trier par:</span>
                <button id="addButton" class="btn btn-green">Ajouter Magasin</button>
            </div>
        </div>

        <div class="store-info">
            <h4>Nom du Magasin</h4>
            <p>Dernière Livraison: <span>--date--</span></p>
            <div class="product-list">
                <button  class="addButton2 btn btn-green">Ajouter un produit</button>
            </div>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>Noms Produit</th>
                    <th>Qt en stock</th>
                    <th>Qt en rayon</th>
                    <th>Qt Vendus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Produit 1</td>
                    <td>10</td>
                    <td>5</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Produit 2</td>
                    <td>8</td>
                    <td>3</td>
                    <td>2</td>
                </tr>
                <!-- Ajoutez d'autres lignes ici si nécessaire -->
            </tbody>
        </table>
    </div>

    <div class="content-body">

        <div class="store-info">
            <h4>Nom du Magasin</h4>
            <p>Dernière Livraison: <span>--date--</span></p>
            <div class="product-list">
                <button  class="addButton2 btn btn-green">Ajouter un produit</button>
            </div>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>Noms Produit</th>
                    <th>Qt en stock</th>
                    <th>Qt en rayon</th>
                    <th>Qt Vendus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Produit 1</td>
                    <td>10</td>
                    <td>5</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Produit 2</td>
                    <td>8</td>
                    <td>3</td>
                    <td>2</td>
                </tr>
                <!-- Ajoutez d'autres lignes ici si nécessaire -->
            </tbody>
        </table>
    </div>
    
</div>
<!-- Pop-up Modal add magasin -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Ajouter un Magasin</h2>
        
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <div class="form-col">
            <div>
                <label for="store">Magasin</label>
                <select id="store">
                    <option value="ampliat">Ampliat...</option>
                <!-- Autres options ici -->
                </select>
            </div>
            
            <div>
                <label for="lieu">Lieu</label>
                <select id="lieu">
                    <option value="ampliat">Douala</option>
                <!-- Autres options ici -->
                </select>
            </div>
        </div>
    
        <!-- Bouton Ajouter en bas -->
        <button class="add-button">Ajouter</button>
    </div>
</div>  

<div id="productModal2" class="modal">
    <div class="modal-content">
        <span class="close-button2">&times;</span>
        <h2>Ajouter un Produi</h2>
        
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <div class="form-col">
            <div class="my-form-container">
                <form class="my-form">
                    <div>
                        <input id="check-1" type="checkbox" name="kara" />
                        <label for="kara">Kara</label>
                    </div>
                    <div>
                        <input checked="kara" id="check-2" type="checkbox" name="kara" />
                        <label for="kara">Kara</label>
                    </div>
                    <div>
                        <input id="kara" type="checkbox" name="kara" />
                        <label for="kara">kara</label>
                    </div>
                    <div>
                        <input id="kara" type="checkbox" name="kara" />
                        <label for="kara">kara</label>
                    </div>
                </form>
                <!-- Autres options ici -->
            </div>
    
        <!-- Bouton Ajouter en bas -->
        <button class="add-button">Ajouter</button>
        </div>
    </div>
</div>  


<?php include_once("../includes/footer.php"); ?>
