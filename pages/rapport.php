<?php $titre = "Rapport tournees"; 
include_once("../includes/sidebar-mobile.php");

// Insérer le header
include_once("../includes/header.php");

// Insérer la Sidebar
include_once("../includes/sidebar.php");
?>

<div class="page-container-report">
    <div class="content-header-report">
        <h2>Tournées</h2>
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