<?php $titre = "Tournées"; 
    $namePage = "tournee-com.php";
include("../includes/sidebar-mobile-com.php");
// Insérer le header
include("../includes/header.php");

// Insérer la Sidebar commercial
include("../includes/sidebar-com.php");
?>

<!-- Main Content Area -->
<div class="main-content">
    <header>
        <div class="page-controls">
            <h2>Tournées</h2>
            <button id="addButton" class="btn-purple">Ajouter Tournée</button>
        </div>
    </header>



    <!-- Table Container valider-->
    <div class="table-container">
            <h3 style="display:inline" >Tournée 1 - Nom Commercial </h3>
            <span style="margin:5px; color:green" >Valider</span>
        

        <div class="toolbar">
        <div>
            <button class="addButton2 btn btn-green">Modifier</button>
        </div>
    </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom Magasin</th>
                    <th>Date</th>
                    <th>Jour</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nom Magasin1</td>
                    <td>14/12/2024</td>
                    <td>Mardi</td>
                </tr>
                <tr>
                    <td>Nom Magasin1</td>
                    <td>14/12/2024</td>
                    <td>Mardi</td>
                </tr>
                <tr>
                    <td>Nom Magasin1</td>
                    <td>14/12/2024</td>
                    <td>Mardi</td>
                </tr>
                <!-- Repeat rows as needed -->
            </tbody>
        </table>
    </div>
    <!-- Table Container en attente-->
    <div class="table-container">
        <h3 style="display:inline" >Tournée 1 - Nom Commercial </h3>
        <span style="margin:5px; color:red; font-style:italic" >en attente</span>
        
        <div class="toolbar">
        <div>
            <button class="btn btn-green">Modifier</button>
        </div>
    </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom Magasin</th>
                    <th>Date</th>
                    <th>Jour</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nom Magasin1</td>
                    <td>14/12/2024</td>
                    <td>Mardi</td>
                </tr>
                <tr>
                    <td>Nom Magasin1</td>
                    <td>14/12/2024</td>
                    <td>Mardi</td>
                </tr>
                <tr>
                    <td>Nom Magasin1</td>
                    <td>14/12/2024</td>
                    <td>Mardi</td>
                </tr>
                <!-- Repeat rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Pop-up Modal add tournees -->
    <div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
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
                <label for="date">Date</label>
                <input name="date" type="date">
            </div>

            <div>
                <label for="jour">Jour</label>
                <select id="jours">
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimache">Dimache</option>
                <!-- Autres options ici -->
                </select>
            </div>
        </div>
    
        <!-- Bouton Ajouter en bas -->
        <button class="add-button">Ajouter</button>
    </div>
    </div> 

    <!-- Pop-up Modal edit tournee -->
    <div id="productModal2" class="modal">
    <div class="modal-content">
        <span class="close-button2" onclick="closeModal()">&times;</span>
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
                <label for="date">Date</label>
                <input name="date" type="date">
            </div>

            <div>
                <label for="jour">Jour</label>
                <select id="jours">
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimache">Dimache</option>
                <!-- Autres options ici -->
                </select>
            </div>
        </div>    
        <!-- Bouton Ajouter en bas -->
        <button class="add-button">Ajouter</button>
    </div>
    </div> 

</div>



<?php include("../includes/footer.php"); ?>
