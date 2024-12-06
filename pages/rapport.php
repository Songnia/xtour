<?php $titre = "Rapport tournees"; 
include_once("../includes/sidebar-mobile.php");

// Insérer le header
include_once("../includes/header.php");

// Insérer la Sidebar
include_once("../includes/sidebar.php");
?>

<div class="page-container-report">
    <div class="content-header-report" >
        <h2>Tournées</h2>
        <div class="group1" style="width: 85%">
            <input type="text" placeholder="Rechercher" class="search-store" id="searchInput"  >
            <svg id="go" class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
        </div>
    </div>
    <div id="containterFilter">
        <div id="elementsFilter">
            <!-- Exemple avec des sélecteurs -->
            <div class="divFilter">
                <label for="filter2">Par Magasin :</label>
                <div class="radio-inputs">
                <label class="radio">
                    <input type="radio" name="radio" checked="">
                    <span class="name">Magasin1</span>
                </label>
                <label class="radio">
                    <input type="radio" name="radio">
                    <span class="name">Magasin2</span>
                </label>
                    
                <label class="radio">
                    <input type="radio" name="radio">
                    <span class="name">Magasin3</span>
                <label>
                </div>        
            </div>


            <div class="divFilter">
                <label for="filter2">Par Produit :</label>
                <div class="radio-inputs">
                <label class="radio">
                    <input type="radio" name="radio" checked="">
                    <span class="name">Produit1</span>
                </label>
                <label class="radio">
                    <input type="radio" name="radio">
                    <span class="name">Produit2</span>
                </label>
                    
                <label class="radio">
                    <input type="radio" name="radio">
                    <span class="name">Produit3</span>
                <label>
                </div>        
            </div>

            <div class="divFilter">
                <label for="filter2">Par Date :</label>
                <div class="radio-inputs">
                <label class="radio">
                    <input type="radio" name="radio" checked="">
                    <span class="name">Plus recent d'abord</span>
                </label>
                <label class="radio">
                    <input type="radio" name="radio">
                    <span class="name">mois recent d'abord</span>
                </label>
                </div>        
            </div>
        </div>
    </div>
    <div class="content-body-report">

        <div class="report-card">
            <div class="image-placeholder">
                <p>Image.</p>
            </div>

            <div class="report-details">
                <h4>Nom du Comercial</h4>
                <p>Nom du Magasin</p>
                <p>Nom du Produit</p>
                <ul>
                    <li>L'étiquette du magasin correspond au produit:</li>
                    <li>Date de Fabrication: --date--</li>
                    <li>Date de Péremption: --date--</li>
                    <li>État du Produit: --état--</li>
                    <li>Quantité en rayon: --quantité--</li>
                    <li>Quantité en stock: --quantité--</li>
                    <li>Les vendeurs connaissent l'emplacement du produit: --oui/non--</li>
                    <li>Feedback:</li>
                </ul>
                <div class="feedback-placeholder"></div>
        </div>
        </div>
        <div class="report-card">
            <div class="image-placeholder">
                <img src="../assets/ph.png" alt="">
            </div>

            <div class="report-details">
                <h4>Nom du Comercial</h4>
                <p>Nom du Magasin</p>
                <p>Nom du Produit</p>
                <ul>
                    <li>L'étiquette du magasin correspond au produit:</li>
                    <li>Date de Fabrication: --date--</li>
                    <li>Date de Péremption: --date--</li>
                    <li>État du Produit: --état--</li>
                    <li>Quantité en rayon: --quantité--</li>
                    <li>Quantité en stock: --quantité--</li>
                    <li>Les vendeurs connaissent l'emplacement du produit: --oui/non--</li>
                    <li>Feedback:</li>
                </ul>
                <div class="feedback-placeholder"></div>
        </div>
        </div>
</div>
</div>


<button id="addButton"></button>

<?php include_once("../includes/footer.php");?>