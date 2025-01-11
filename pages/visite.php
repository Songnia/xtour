<?php $titre = "Tournées"; 
//❌❌❌❌❌ les utilisateurs seront❌❌❌❌ rediriger vers la page❌❌❌❌ des tournee en fonction de leur type ❌❌❌❌❌ en Php
include("../includes/sidebar-mobile-com.php");
// Insérer la Sidebar commercial
include("../includes/sidebar-com.php");

// Insérer le header
include("../includes/header.php");
include_once("../includes/classes/Produit.php");
include_once("../includes/classes/Database.php");
include_once("../includes/classes/Magasin.php");
$database = new Database();
$db = $database->getConnection();

$magasin = new Magasin($db);
$produit = new Produit($db);
$prods = $produit->read();

try {
    $query = "
    SELECT 
        v.id_visite,
        v.codeTournee,
        v.magasin_id,
        v.ville,
        sp.produit_id
    FROM 
        Visite v

    LEFT JOIN 
        stocks_produits sp ON v.id_visite = sp.visite_id
    ORDER BY 
    v.id_visite DESC;

    ";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $resultas = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Erreur capturée : " . $e->getMessage();
    return false;
}

echo"<pre>";
//var_dump($resultas);
echo"</pre>";

$nom = isset($_GET['nomMagasin']) ? $_GET['nomMagasin'] : '';
$ville = isset($_GET['villeMagasin']) ? $_GET['villeMagasin'] : '';
$code = isset($_GET['codeTournee']) ? $_GET['codeTournee'] : '';
echo"<pre>";
//var_dump($nom);
echo"</pre>";
if(empty($nom) and empty($ville) and empty($code)){
    $nom = $magasin->getNameMagasin($resultas["magasin_id"]);
    $code = $resultas['codeTournee'];
    $ville = $resultas['ville'];
}
echo"<pre>";
//var_dump($nom);
echo"</pre>";

//echo "code= ".$code;
?>
    <!-- Page Content -->
    <main class="container">
        <h1>Tournées</h1>
        <form id="productForm" method="POST" enctype="multipart/form-data" action="../includes/classes/enregistrerVisite.php" enctype="multipart/form-data">
            <!-- Vérification générale -->
             <input type="hidden" name="codeTournee" value="<?php echo $code; ?>">
            <section class="section">
                <h2>Vérification générale</h2>

                    <div>
                        <hr>
                    </div>                    
                    <div class="question" ><label for="Ville">Ville</label>

                        <select name="ville" id="ville_visite">
                            <option value="Douala"<?php if ($ville == 'Douala') echo 'selected'; ?>>Douala</option>
                            <option value="Yaounde"<?php if ($ville == 'Yaounde') echo 'selected'; ?>>Yaounde</option>
                        </select>
                    </div>
                    <div class="question">
                        <label for="store">Magasin</label>
                        <?php
                            if(isset($ville) and !empty($ville)){
                                try{
                                    $query = "SELECT nom FROM Magasin WHERE ville =:ville ORDER BY date_enregistrement DESC";
                                    $stmt = $db->prepare($query);
                                    $stmt->bindParam(":ville", $ville);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    //var_dump($result);
                                } catch (Exception $e) {
                                        // Annuler la transaction en cas d'erreur
                                        $db->rollBack();
                                        error_log($e->getMessage());
                                        echo "Erreur capturée : " . $e->getMessage();
                                        return false;
                                }
                            }else{
                                try{
                                    $query = "SELECT nom FROM Magasin ORDER BY date_enregistrement DESC";
                                    $stmt = $db->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    //var_dump($result);
                                } catch (Exception $e) {
                                        // Annuler la transaction en cas d'erreur
                                        $db->rollBack();
                                        error_log($e->getMessage());
                                        echo "Erreur capturée : " . $e->getMessage();
                                        return false;
                                }                                    
                            }
                        ?> 
                        <select name="nom" id="magasin_visite">
                        <option value="">Sélectionnez un magasin</option>
                            <?php foreach($result as $res): ?>
                                <option value="<?php echo htmlspecialchars($res['nom']); ?>" <?php if ($nom == $res['nom']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($res['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select> 
                    </div>  
                    <div class="question">
                        <label for="product">Produit</label>
                        <?php
                            if(isset($nom) || !empty($nom)){
                                $id_magasin = $magasin->getIDMagasin($nom);
                                $id_magasin = $id_magasin['id_magasin'];

                                //var_dump($id_magasin);
                                $produit_magasin = $magasin->getProduit($id_magasin);
                                echo "<pre>";
                                //var_dump($produit_magasin);
                                echo "</pre>";
                        ?>
                        <select id="product" name="product" required>
                            <?php
                            if (!empty($produit_magasin)) {
                                foreach ($produit_magasin as $prod) { ?>
                                    <option value="<?php echo $prod['produit']; ?>">
                                        <?php echo $prod['produit']; ?>
                                    </option>
                                <?php }
                            } else {
                                if (isset($prods)) {
                                    var_dump($prods);
                                    foreach ($prods as $prod) { ?>
                                        <option value="<?php echo $prod['nom_commercial']; ?>">
                                            <?php echo $prod['nom_commercial']; ?>
                                        </option>
                                    <?php } 
                                }else{?>
                                    <option value="">-- Aucun produit disponible --</option>
                                <?php } }
                            }
                            ?>
                        </select>

                    </div>         

                    <div class="question">
                        <p>le produit a t-il un bon emplacement et est bien visible ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="visibiliter" value="yes" required> Oui</label>
                            <label><input type="radio" name="visibiliter" value="no" required> Non</label>
                        </div>
                    </div>

                    <div class="question">
                        <p>Est ce que l'étiquettes correspondent à l'emplacement du produit ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="etiquette" value="yes" required> Oui</label>
                            <label><input type="radio" name="etiquette" value="no" required> Non</label>
                        </div>
                    </div>

                    <div>
                        <p>Quel est le prix sur l'etiquette du produit ?</p>
                        <input type="number" name="prix" placeholder="prix..." class="prix">
                    </div>

                     <div id="espace">
                        <hr>
                     </div>

                    <div class="infoProduit" class="question">
                        <label for="etat">État du Produit</label>
                        <select id="etat" name="etat" required>
                            <option value="bon">Bon</option>
                            <option value="moyen">Moyen</option>
                            <option value="mauvais">Mauvais</option>
                        </select>
                    </div>
                    <div class="stock-info" class="question">
                        <div class="infoProduit">
                            <label for="dateFab">Date de fabrication</label>
                            <input type="date" id="dateFab" name="dateFab" required>
                        </div>
                        <div class="infoProduit">
                            <label for="dateExp">Date d'expiration</label>
                            <input type="date" id="dateExp" name="dateExp" required>
                        </div>
                    </div>

                    <div id="InformationProduit" class="question" style="margin-bottom:10px;margin-top:10px">
                        <div>
                            <label for="quantityRayon" style="margin-top:10px">Quantité en rayon</label>
                            <div class="infoQuantite" >
                                <input type="number" id="quantityRayon" name="quantiteRayon" placeholder="Entrez la quantité en rayon" >
                                <label><input type="radio" name="quantiteRayonQTS" value="QTS"> QTS</label>
                            </div>  
                            <span class="detailqs">QTS = Quantiter suffisante</span>
                        </div>
                        
                        <div class="question">
                            <label for="quantityStock" style="margin-top:10px">Quantité en stock</label>
                            <div class="infoQuantite" >
                                <input type="number" id="quantityStock" name="quantiteStock" placeholder="Entrez la quantité en stock">
                                <label><input type="radio" name="quantiteStockQTS" value="QTS"> QTS</label>
                                <label><input type="radio" name="quantiteStockQTS" value="NA"> NA</label>

                            </div>
                            <span class="detailqs">NA = Non accessible</span>
                        </div>

                    </div>
                    
                    <div>
                        <hr>
                    </div>

                    <div class="question" style="margin-bottom:10px,margin-top:40px">
                        <p>Les vendeurs connaissent l'emplacement des produits ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="emplacement" value="yes" required> Oui</label>
                            <label><input type="radio" name="emplacement" value="no" required> Non</label>
                        </div>
                    </div>


                    <div class="question">
                        <p>Le magasin a t-il une promotrice ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="existance_promotrice" value="yes" oninput="openPromotrice()" required> Oui</label>
                            <label><input type="radio" name="existance_promotrice" value="no" required oninput="hiddenPromotrice()"> Non</label>
                        </div>
                    </div>

                    <div class="question" id="promotrice">
                        <p>La promotrice est elle presente ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="presence_promotrice" value="yes" > Oui</label>
                            <label><input type="radio" name="presence_promotrice" value="no" > Non</label>
                        </div>
                    </div>
                    <div class="question">
                        <div class="FeedLabel">
                            <label for="feedback">Feedbacks</label>
                            <div >
                                <label class="feedback_value"><input type="radio" name="feedback_value" value="Très bon" >Tres bon</input></label>
                                <label class="feedback_value"><input type="radio" name="feedback_value" value="Bon" >Bon</input></label>
                            </div>

                            <div>
                                <label class="feedback_value" for=""><input type="radio" name="feedback_value" value="Moyen" >Moyen</input></label>
                                <label class="feedback_value" for=""><input type="radio" name="feedback_value" value="Pas bon" >Pas bon</input></label>
                            </div>
                        </div>
                        <textarea id="feedback" name="decription" placeholder="Feedback..."></textarea>                        
                    </div>

                </section>

                <!-- Gestion des stocks -->
                <section class="section">
                <!--<h2>Gérer les stocks</h2>-->
                <hr>
                
                <section class="section">
                        <label for="imageUpload">Importer les images</label>
                        <label class="custum-file-upload" for="file">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                            </div>
                            <div class="text">
                            <span>Click to upload image</span>
                            </div>
                            <input type="file" id="file" name="image" >
                       </label>
                </section>
            </section>


            <!-- Bouton de soumission -->
            <button type="submit" class="submit-btn">Enregistrer</button>
        </form> 
        <?php include("../includes/footer.php"); ?>
    </main>
        
    
</body>
</html>
