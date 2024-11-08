<?php $titre = "Tournées"; 
//❌❌❌❌❌ les utilisateurs seron❌❌❌❌t rediriger vers la page❌❌❌❌ des tournee en fonction de leur type ❌❌❌❌❌ en Php
include("../includes/sidebar-mobile-com.php");
// Insérer la Sidebar commercial
include("../includes/sidebar-com.php");

// Insérer le header
include("../includes/header.php");

?>
    <!-- Page Content -->
    <main class="container">
        <h1>Tournées</h1>
        <form id="productForm" method="POST" action="enregistrerProduit.php" enctype="multipart/form-data">
            <!-- Vérification générale -->
            <section class="section">
                <h2>Vérification générale</h2>
                <hr>
                
                <label for="store">Magasin</label>
                <select id="magasin" name="magasinName" required>
                    <option value="kara">Ampiat</option>
                    <!-- Ajoutez d'autres magasins si nécessaire -->
                </select>

                <div class="question">
                    <p>Les étiquettes correspondent à l'emplacement du produit ?</p>
                    <div class="reponse">
                        <label><input type="radio" name="labels" value="yes" required> Oui</label>
                        <label><input type="radio" name="labels" value="no" required> Non</label>
                    </div>
                </div>

                <div class="question">
                    <p>Les vendeurs connaissent l'emplacement des produits ?</p>
                    <div class="reponse">
                        <label><input type="radio" name="vendors_knowledge" value="yes" required> Oui</label>
                        <label><input type="radio" name="vendors_knowledge" value="no" required> Non</label>
                    </div>
                </div>

                <label for="feedback">Feedbacks</label>
                <textarea id="feedback" name="feedback" placeholder="Feedback..."></textarea>

                <label for="imageUpload">Importer l'image</label>
                    <label class="custum-file-upload" for="file">
                        <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                        </div>
                        <div class="text">
                        <span>Click to upload image</span>
                        </div>
                        <input type="file" id="file" name="image">
                    </label> 
            </section>

            <!-- Gestion des stocks -->
            <section class="section">
                <h2>Gérer les stocks</h2>
                <hr>

                <label for="product">Produit</label>
                <select id="product" name="product" required>
                    <option value="kara">Kara</option>
                    <!-- Ajoutez d'autres options de produit si nécessaire -->
                </select>

                <div class="stock-info">
                    <div class="infoProduit">
                        <label for="dateFab">Date de fabrication</label>
                        <input type="date" id="dateFab" name="dateFab" required>
                    </div>
                    <div class="infoProduit">
                        <label for="dateExp">Date d'expiration</label>
                        <input type="date" id="dateExp" name="dateExp" required>
                    </div>
                </div>

                <div class="infoProduit">
                    <label for="etat">État</label>
                    <select id="etat" name="etat" required>
                        <option value="bon">Bon</option>
                        <option value="moyen">Moyen</option>
                        <option value="mauvais">Mauvais</option>
                    </select>
                </div>

                <div id="InformationProduit" style="margin-bottom:10px">
                    <label for="quantityRayon">Quantité en rayon</label>
                    <div class="infoQuantite">
                        <input type="number" id="quantityRayon" name="quantityRayon" required>
                        <label><input type="checkbox" name="quantityRayonQTS" value="QTS"> QTS</label>
                    </div>
                        
                    <label for="quantityStock">Quantité en stock</label>
                    <div class="infoQuantite">
                        <input type="number" id="quantityStock" name="quantityStock" required>
                        <label><input type="checkbox" name="quantityStockQTS" value="QTS"> QTS</label>
                    </div>
                </div>
            </section>

            <!-- Bouton de soumission -->
            <button type="submit" class="submit-btn">Enregistrer</button>
        </form> 
        <button id="addButton"></button>
        <?php include("../includes/footer.php"); ?>
    </main>
        
    
</body>
</html>
