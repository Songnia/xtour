<?php $titre = "Tournées"; 
    $namePage = "tournee-res-com.php";
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


    <!-- Table Container -->
    <div class="table-container">
        <h3>Tournée 1 - Nom Commercial</h3>
        <div class="toolbar">
        <div>
            <button class="addButton2 btn btn-green">Modifier</button>
            <button class="buttonValider btn btn-green ">Valider</button>
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
    <!-- Table Container -->
    <div class="table-container">
        <h3>Tournée 1 - Nom Commercial</h3>
        <div class="toolbar">
        <div>
            <button class="btn btn-green">Modifier</button>
            <button class="buttonValider btn btn-green">Valider</button>
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
</div>

<!-- Pop-up Modal add visite -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Ajouter une Tournée</h2>
        
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

<div id="productModal2" class="modal">
    <div class="modal-content">
        <span class="close-button2">&times;</span>
        <h2>Modifier</h2>
        
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
<!-- Confirm validation -->
<div class="modal" id="modal3">
    <div class="card ">
        <div class="image">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        </div>
        <p class="cookieHeading">Vous validez la tournée</p>

        <div class="buttonContainer">
            <button class="acceptButton">Allow</button>
            <button class="declineButton">Decline</button>
        </div>
    </div>
</div>



<?php include("../includes/footer.php"); ?>
