<?php $titre = "Rapport tournees"; 
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

try {
    $query = "
    SELECT 
        v.id_visite,
        v.codeTournee,
        v.magasin_id,
        v.ville,
        v.date_visite,
        v.feedback,
        v.feedback_value,
        v.feedback_description,
        sp.id_stock,
        sp.produit_id,
        sp.date_fabrication,
        sp.date_expiration,
        sp.etat AS stock_etat,
        sp.quantite_rayon,
        sp.quantite_stock,
        sp.qts_rayon,
        sp.qts_stock,
        sp.image_path,
        rv.id_reponse,
        rv.etiquette,
        rv.presence_promotrice,
        rv.existance_promotrice,
        rv.emplacement,
        rv.visibilite_produit,
        rv.prix_etiquette
    FROM 
        Visite v
    LEFT JOIN 
        stocks_produits sp ON v.id_visite = sp.visite_id
    LEFT JOIN 
        reponses_verification rv ON v.id_visite = rv.visite_id;
    ";

    $stmt = $db->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Erreur capturée : " . $e->getMessage();
    return false;
}

echo"<pre>";
//var_dump($results);
echo"</pre>";
?>
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

    /**Style Image */
    .mySlides {display: none}
    img {vertical-align: middle;}

    /* Slideshow container */
    .slideshow-container {
    display: none;
    margin: auto;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    }
    .modal-slide-content {

    background-color: #fff;
    width: 500px;
    height: 500px;
    margin:5% auto;
    text-align: left;
    position: relative;
    }

    .mySlides img{
    width: 500px;
    height: 500px;
    }

    /* Next & previous buttons */
    .prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
    right: 0;
    border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
    }

    /* Caption text */
    .text {
    color: #f2f2f2;
    font-size: 15px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    width: 100%;
    text-align: center;
    }

    /* Number text (1/3 etc) */
    .numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
    }

    /* The dots/bullets/indicators */
    .dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
    }

    .active, .dot:hover {
    background-color: #717171;
    }

    /* Fading animation */
    .fade {
    animation-name: fade;
    animation-duration: 1.5s;
    }

    @keyframes fade {
    from {opacity: .4} 
    to {opacity: 1}
    }

    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
    .prev, .next,.text {font-size: 11px}
    }

    </style>
<div class="page-container-report">
    <div class="page-controls">
                <div id="h3-inline"> <h3 id="maga-h3">Tournees</h3> 
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
    <div class="content-body-report content-body">

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
    <div class="container-scroll">
        <div class="table-section">
        <table>
        <thead>
            <tr>
            <th>ID</th>
            <th>ville</th>
            <th>nom Magasin</th>
            <th>Nom du Produit</th>
            <th>Visible</th>
            <th>Etiquette</th>
            <th>Prix</th>
            <th>Etat</th>
            <th>Date de Fabrication</th>
            <th>Date de Péremption</th>
            <th>Quantité en rayon</th>
            <th>vendeurs</th>
            <th>Feedback</th>
            <th>images</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
            <tr>
                <td><?php echo htmlspecialchars($result['id_visite']); ?></td>
                <td><?php echo  htmlspecialchars($result['ville']); ?></td>
                <td>
                    <?php
                        $magasinName = $magasin->getNameMagasin($result["magasin_id"]);
                        echo htmlspecialchars($magasinName); 
                    ?>
                </td>
                <td>
                    <?php 
                        echo $produit->getNameProduit(htmlspecialchars($result['produit_id'])); 
                    ?>
                </td>
                <td><?php echo htmlspecialchars($result['visibilite_produit']); ?></td>
                <td><?php echo  htmlspecialchars($result['ville']); ?></td>
                <td><?php echo htmlspecialchars($result['prix_etiquette']); ?></td>
                <td><?php echo htmlspecialchars($result['stock_etat']); ?></td>
                <td><?php echo htmlspecialchars($result['date_fabrication']); ?></td>
                <td><?php echo  htmlspecialchars($result['date_expiration']); ?></td>
                <td>
                    <?php
                        try{
                            $query = "SELECT quantite_rayon
                            FROM stocks_produits
                            WHERE quantite_rayon > 0
                            AND nom = :nom
                            ORDER BY id_stock DESC
                            LIMIT 1";
                        $stmt = $db->prepare($query);
                        
                        // Lier la variable idMagasin à la requête
                        $stmt->bindParam(':nom',$magasinName);

                        $qt_rayon = $stmt->fetch(PDO::FETCH_ASSOC);
                        $qt_rayon = $qt_rayon['quantite_rayon'];
                        } catch (Exception $e) {
                            // Journaliser l'erreur pour le débogage
                            error_log($e->getMessage());
                            echo "Erreur capturée : " . $e->getMessage();
                        }
                            echo $qt_rayon; 
                    ?>
                </td>
                <td><?php echo htmlspecialchars($result['emplacement']); ?></td>
                <td><?php echo htmlspecialchars($result['feedback_value']); ?></td>
                <td>
                    <?php 
                        $image = $result['image_path'];
                        echo "<img onclick='openModalSlide()' src='$image' alt='Image téléchargée' style='max-width:30px; max-height:30px;'>"
                        
                    ?>
                    <div class="slideshow-container" id="slide">
                        <div class="modal-slide-content">
                                <div class="mySlides fade">
                            <div class="numbertext">1 / 3</div>
                            <img src="../includes/classes/images/0ad4ad518640d4db1870a7b5142b390e.jpg" style='max-width:500px; max-height:500px;'>
                            <div class="text">Caption Text</div>
                            </div>

                            <div class="mySlides fade">
                            <div class="numbertext">2 / 3</div>
                            <img src="../includes/classes/images/fcc0f40d3422e3263075864f72d74314.png" style='max-width:500px; max-height:500px;'">
                            <div class="text">Caption Two</div>
                            </div>

                            <div class="mySlides fade">
                            <div class="numbertext">3 / 3</div>
                            <img src="../includes/classes/images/0ad4ad518640d4db1870a7b5142b390e.jpg" style='max-width:500px; max-height:500px;'>
                            <div class="text">Caption Three</div>
                            </div>

                            <div class="mySlides fade">
                            <div class="numbertext">3 / 3</div>
                            <img src="../includes/classes/images/0ad4ad518640d4db1870a7b5142b390e.jpg" style='max-width:500px; max-height:500px;'>
                            <div class="text">Caption Three</div>
                            </div>

                            <a class="prev" onclick="plusSlides(-1)">❮</a>
                            <a class="next" onclick="plusSlides(1)">❯</a>

                            
                            <br>

                            <div style="text-align:center">
                            <span class="dot" onclick="currentSlide(1)"></span> 
                            <span class="dot" onclick="currentSlide(2)"></span> 
                            <span class="dot" onclick="currentSlide(3)"></span> 
                            <span class="dot" onclick="currentSlide(4)"></span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <!-- Ajouter d'autres lignes pour chaque Produit -->
        </tbody>
        </table>
    </div>
    </div>
</div>


<button id="addButton"></button>

<?php include_once("../includes/footer.php");?>