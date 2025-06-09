<link rel="icon" type="image/png" sizes="32x32" href="Visimags-carre1.png">
<?php

$titre = "Rapport tournees";
//error_reporting(E_ALL);
session_start();
switch($_SESSION['role']) {/*'Admin', 'Commercial', 'responsable_commercia...	*/
    case 'Admin': 
    include_once("../includes/sidebar-mobile.php");
    include_once("../includes/sidebar.php");
    break;
    
    default:
    include_once("../includes/sidebar-com.php");
    include("../includes/sidebar-mobile-com.php");
}
include_once("../includes/header.php");
include_once("../includes/classes/Database.php");
include_once("../includes/classes/Magasin.php");
include_once("../includes/classes/Produit.php");
include_once("../includes/classes/User.php");

$database = new Database();
$db = $database->getConnection();
$magasin = new Magasin($db);
$produit = new Produit($db);
$user = new Utilisateur($db);

// Récupération des filtres depuis l'URL
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $ville = isset($_GET['ville']) ? $_GET['ville'] : '';
    $magasin_id = isset($_GET['magasin']) ? $_GET['magasin'] : '';
    $groupe = isset($_GET['groupe']) ? $_GET['groupe'] : '';
    $produit_id = isset($_GET['produit']) ? $_GET['produit'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';
}

// Construire la clause WHERE dynamiquement
$conditions = [];
$params = [];

if (!empty($ville)) {
    $conditions[] = "v.ville = ?";
    $params[] = $ville;
}
if (!empty($magasin_id)) {
    $conditions[] = "v.magasin_id = ?";
    $params[] = $magasin_id;
}
if (!empty($groupe)) {
    $conditions[] = "m.groupe = ?";
    $params[] = $groupe;
}
if (!empty($produit_id)) {
    $conditions[] = "sp.produit_id = ?";
    $params[] = $produit_id;
}
if (!empty($date)) {
    //$conditions[] = "v.date_visite = ?";
    $order = "ASC";
    $order = $date;
}
//echo $order;
$whereClause = count($conditions) > 0 ? ' WHERE ' . implode(' AND ', $conditions) : '';

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
        rv.prix_etiquette,
        m.groupe
    FROM 
        Visite v
    LEFT JOIN 
        stocks_produits sp ON v.id_visite = sp.visite_id
    LEFT JOIN 
        reponses_verification rv ON v.id_visite = rv.visite_id
    LEFT JOIN 
        Magasin m ON m.id_magasin = v.magasin_id
    $whereClause
    ORDER BY v.date_visite $order;
    ";

    $stmt = $db->prepare($query);
    $stmt->execute($params);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Erreur capturée : " . $e->getMessage();
    return false;
}

// Afficher les résultats
echo "<pre>";
//var_dump($results);
echo "</pre>";
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
    /*height: 15px;
    width: 15px;*/
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

    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    }

.container {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    overflow-x: auto;
}

.filter-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    flex-wrap: nowrap;
    align-items: baseline;

}

.filter-button {
    background: white;
    font-weight: bold;
    border: none;
    padding: 10px;
    border-radius: 30px;
    cursor: pointer;
    min-width: 70px;
}

.filter-select, .filter-input {
    background: white;
    padding: 5px;
    border: 1px solid white;
    border-radius: 30px;
    flex: 1;
    
}

.apply-button-container {
    text-align: start;
    margin-top: 10px;
}

.apply-button {
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-weight: bold;
}
.apply-button:hover{
    background:rgb(9, 99, 195);
}
.apply-button-green{
    background-color: #4caf50;
}
.apply-button-green:hover{
    background-color:#45a049;
}
@media (max-width: 576px) {
body{
    padding: 0;
}
.filter-button {
    font-size: xx-small;
    width: 75px;
    height: 30px;
}

#date{
    font-size: xx-small;
}

.filter-select, .filter-input {
    font-size: xx-small;
    width: 75px;
    height: 30px;
}

.apply-button-container {
    font-size: xx-small;
    width: 75px;
    height: 20px;
}
.apply-button-container {
    margin-bottom: 10px;
    margin-top: 0px;
    height: 30px;
    font-size: xx-small;
}
search-store{
    max-width: 300px;
}
.radio-inputs{
    display: none;
}
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
                    <!--<label class="radio" onclick="showDetail()">
                        <input id="detail" type="radio" name="radio">
                        <span class="name">plus de detaille</span>
                    </label>-->
                    </div>
                </div>
                <div id="filterContainer" class="filter-container">
                    <div id="selectedFilters" class="selected-filters">
                    <!-- Les tags sélectionnés s'afficheront ici 
                        <div class="group1">
                            <input type="text" placeholder="Rechercher" class="search-store" id="searchInput">
                            <svg id="go" class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
                        </div>-->
                    </div>
                </div>
        <form method="POST" action="../includes/classes/export_csv.php">
            <button class="apply-button apply-button-green" type="submit" >Télécharger le rapport en CSV</button>
        </form></div>
    </div>
    <div>
        <?php 
            try{
                $query = "SELECT * FROM Magasin ORDER BY date_enregistrement DESC";
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
            
            try{
                $query = "SELECT DISTINCT groupe FROM Magasin";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result_group = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //var_dump($result_group);
            } catch (Exception $e) {
                                    // Annuler la transaction en cas d'erreur
                                    $db->rollBack();
                                    error_log($e->getMessage());
                                    echo "Erreur capturée : " . $e->getMessage();
                                    return false;
            }

            $prods = $produit->read();              
        ?>        
        <form method="GET" class="container">
            <div class="filter-bar">
                <button class="filter-button">🔍 Tout</button>
                <select class="filter-select" id="ville" name="ville">
                    <option value="">Ville</option>
                    <option value="Douala">Douala</option>
                    <option value="Yaounde">Yaounde</option>
                </select>
                <select class="filter-select" id="groupe" name="groupe" >
                    <option value="">Groupe</option>
                    <?php foreach($result_group as $index => $resg): 
                        if(!empty($resg['groupe'])){
                        ?>
                        <option value="<?php echo htmlspecialchars($resg['groupe']); ?>">
                                    <?php echo htmlspecialchars($resg['groupe']); ?>
                        </option>
                    <?php }
                        endforeach; 
                    ?>                    
                </select>
                <select class="filter-select" id="magasin" name="magasin" >
                    <option value="">Magasin</option>
                    <?php foreach($result as $res): ?>
                        <option value="<?php echo htmlspecialchars($res['id_magasin']); ?>" <?php if ($nom == $res['nom']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($res['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" id="produit" name="produit">
                    <option value="">Produit</option>
                    <?php 
                        foreach ($prods as $prod) { ?>
                        <option value="<?php echo $prod['id_produit']; ?>">
                            <?php echo $prod['nom_commercial']; ?>
                        </option>
                        <?php }  
                    ?>
                </select>
                <select class="filter-select" id="date" name="date">
                    <option value="">Date</option>
                    <option value="DESC">Plus recent </option>
                    <option value="ASC">Plus encien </option>
                </select>
            </div>
            <div class="apply-button-container">
                <button class="apply-button">Appliquer</button>
            </div>
        </form>

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
            <!--<th>ID</th>
            <th>code de la tournee</th>
            <th>ville</th>
            <th>nom Magasin</th>
            <th>Nom du commercial</th>-->
            <th>code</th>
            <th>Date</th>
            <th>ville</th>
            <th>nom Magasin</th>
            <th>Nom Utilisateur</th>
            <th>Nom du Produit</th>
            <th>Visible</th>
            <th>Etiquette</th>
            <th>Prix</th>
            <th>Etat</th>
            <th>Date de <br>Fabrication</th>
            <th>Date de <br>Péremption</th>
            <th>Quantité <br>en rayon</th>
            <!--<th>Quantité <br>en vendue</th>-->
            <th>vendeurs</th>
            <th>Feedback</th>
            <th>images</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
            <tr>
                <td><?php echo htmlspecialchars($result['codeTournee']); ?></td>
                <td><?php echo htmlspecialchars($result['date_visite']); ?></td>
                <td><?php echo  htmlspecialchars($result['ville']); ?></td>
                <td>
                    <?php
                        $magasinName = $magasin->getNameMagasin($result["magasin_id"]);
                        echo htmlspecialchars($magasinName); 
                    ?>
                </td>
                <th>
                    <?php 
                        try{
                            //echo "ID magasin: ".$maga['id_magasin']."  :id P ".$prodm['id_produit'];
                            
                            $query = "SELECT utilisateur_id FROM Tournee WHERE code = :code";
                            $stmt = $db->prepare($query); // Correction ici
                            $stmt->bindParam(':code', $result['codeTournee'], PDO::PARAM_STR);
                            $stmt->execute();
                            $user_id = $stmt->fetch(PDO::FETCH_ASSOC);
                          } catch (Exception $e) {
                                error_log($e->getMessage());
                                echo "Erreur capturée : " . $e->getMessage();
                                return false;
                          }
                          if($user_id["utilisateur_id"]){
                            $nameUser = $user->getNameCom($user_id["utilisateur_id"]);
                            //var_dump($nameUser);    
                            echo $nameUser[0]["nom"] ." ".$nameUser[0]["prenom"];                        
                          }
                    ?>
                </th>
                <td>
                    <?php 
                        echo $produit->getNameProduit(htmlspecialchars($result['produit_id'])); 
                    ?>
                </td>
                <td><?php echo htmlspecialchars($result['visibilite_produit']); ?></td>
                <td><?php echo  htmlspecialchars($result['etiquette']); ?></td>
                <td><?php echo htmlspecialchars($result['prix_etiquette']); ?></td>
                <td><?php echo htmlspecialchars($result['stock_etat']); ?></td>
                <td><?php echo htmlspecialchars($result['date_fabrication']); ?></td>
                <td><?php echo  htmlspecialchars($result['date_expiration']); ?></td>
                <td>
                    <?php
                        
                        if($result['quantite_rayon']){
                            echo htmlspecialchars($result['quantite_rayon']);
                           }else{
                                echo htmlspecialchars($result['qts_rayon']);
                            }
                        /*try{   
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
                            echo $qt_rayon; */
                    ?>
                </td>
                <td><?php echo htmlspecialchars($result['emplacement']); ?></td>
                <td><?php echo htmlspecialchars($result['feedback_value']); ?></td>
                <td>
                    <?php 
                        $image = $result['image_path'];
                        echo "<img onclick='openModalSlide()' src='$image' alt='Image téléchargée' style='max-width:30px; max-height:30px;'>"
                        
                    ?>
                    <!-- Modal pour afficher les images -->
                    <div class="slideshow-container" id="slide" style="display:none;">
                        <div class="modal-slide-content">
                            <?php
                            // Boucle pour générer les slides
                            foreach ($results as $index => $result) {
                                $image = $result['image_path'];
                                echo '
                                <div class="mySlides fade">
                                    <div class="numbertext">' . ($index + 1) . ' / ' . count($results) . '</div>
                                    <img src="' . $image . '" style="max-width:500px; max-height:500px;">
                                    <div class="text">Caption ' . ($index + 1) . '</div>
                                </div>';
                            }
                            ?>

                            <!-- Boutons précédent/suivant -->
                            <a class="prev" onclick="plusSlides(-1)">❮</a>
                            <a class="next" onclick="plusSlides(1)">❯</a>

                            <!-- Points indicateurs -->
                            <div style="text-align:center">
                                <?php
                                // Boucle pour générer les points indicateurs
                                foreach ($results as $index => $result) {
                                    echo '<span class="dot" onclick="currentSlide(' . ($index + 1) . ')"></span>';
                                }
                                ?>
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