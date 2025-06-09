<?php
// Page d'alerte produits
$titre = "Alertes produits";
session_start();
switch($_SESSION['role']) {
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
//echo "Hello1";
$database = new Database();
$db = $database->getConnection();
$magasin = new Magasin($db);
$produit = new Produit($db);

// Filtres par défaut
$quantite = isset($_GET['quantite']) ? (int)$_GET['quantite'] : 10;

// Récupération de la liste brute des produits vus en tournée (sans filtre)
try {
    $query = "
    SELECT 
        v.id_visite,
        v.codeTournee,
        v.magasin_id,
        v.ville,
        v.date_visite,
        m.nom AS nom_magasin,
        m.groupe,
        p.nom_commercial,
        p.nom_descriptif,
        sp.produit_id,
        sp.date_expiration,
        sp.quantite_rayon,
        sp.quantite_stock
    FROM Visite v
    LEFT JOIN stocks_produits sp ON v.id_visite = sp.visite_id
    LEFT JOIN Magasin m ON m.id_magasin = v.magasin_id
    LEFT JOIN Produit p ON p.id_produit = sp.produit_id
    WHERE (sp.quantite_rayon IS NOT NULL AND sp.quantite_rayon <= :quantite)
    ORDER BY sp.quantite_rayon ASC
    ";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':quantite', $quantite, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    //var_dump($results);
    echo "</pre>";
} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Erreur capturée : " . $e->getMessage();
    return false;
}

//echo "Hello4";
function dureeAvantPeremption($date_expiration) {
    if (!$date_expiration) return 'N/A';
    $aujourd_hui = new DateTime();
    $expiration = new DateTime($date_expiration);
    $interval = $aujourd_hui->diff($expiration);
    if ($expiration < $aujourd_hui) return 'Expiré';
    return $interval->m + ($interval->y * 12) . ' mois, ' . $interval->d . ' jours';
}
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

.page-container-alert {
    margin: 30px auto;
    max-width: 1200px;
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 8px #bbb;
}
.table-section {
    overflow-x: auto;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin: 0 auto;
    background: #fafafa;
}
th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}
th {
    background: #e6f2ff;
}
tr:hover {
    background: #f6faff;
}
.filter-form {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    align-items: center;
}
.filter-form label { font-weight: bold; }
.filter-form input {
    width: 60px;
    padding: 4px 8px;
    border: 1px solid #bbb;
    border-radius: 4px;
}
</style>
<div class="page-container-report">
    <div class="page-controls">
                <div id="h3-inline">
                    <h3 id="maga-h3">Alertes produits</h3> 
                </div>
    </div>
    <div>
        <?php 
            try{
                $query = "SELECT DISTINCT ville FROM Magasin WHERE ville IS NOT NULL AND ville != '' ORDER BY ville ASC";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result_ville = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                $db->rollBack();
                error_log($e->getMessage());
                echo "Erreur capturée : " . $e->getMessage();
                return false;
            }
            try{
                $query = "SELECT DISTINCT groupe FROM Magasin WHERE groupe IS NOT NULL AND groupe != '' ORDER BY groupe ASC";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result_group = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                $db->rollBack();
                error_log($e->getMessage());
                echo "Erreur capturée : " . $e->getMessage();
                return false;
            }
            try{
                $query = "SELECT * FROM Magasin ORDER BY date_enregistrement DESC";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
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
                    <?php foreach($result_ville as $index => $resv): if(!empty($resv['ville'])): ?>
                        <option value="<?php echo htmlspecialchars($resv['ville']); ?>" <?php if(isset($_GET['ville']) && $_GET['ville'] == $resv['ville']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($resv['ville']); ?>
                        </option>
                    <?php endif; endforeach; ?>
                </select>
                <select class="filter-select" id="groupe" name="groupe" >
                    <option value="">Groupe</option>
                    <?php foreach($result_group as $index => $resg): if(!empty($resg['groupe'])): ?>
                        <option value="<?php echo htmlspecialchars($resg['groupe']); ?>" <?php if(isset($_GET['groupe']) && $_GET['groupe'] == $resg['groupe']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($resg['groupe']); ?>
                        </option>
                    <?php endif; endforeach; ?>
                </select>
                <select class="filter-select" id="magasin" name="magasin" >
                    <option value="">Magasin</option>
                    <?php foreach($result as $res): ?>
                        <option value="<?php echo htmlspecialchars($res['id_magasin']); ?>" <?php if(isset($_GET['magasin']) && $_GET['magasin'] == $res['id_magasin']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($res['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" id="produit" name="produit">
                    <option value="">Produit</option>
                    <?php foreach ($prods as $prod): ?>
                        <option value="<?php echo htmlspecialchars($prod['id_produit']); ?>" <?php if(isset($_GET['produit']) && $_GET['produit'] == $prod['id_produit']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($prod['nom_commercial']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" id="date" name="date">
                    <option value="">Date</option>
                    <option value="DESC" <?php if(isset($_GET['date']) && $_GET['date'] == 'DESC') echo 'selected'; ?>>Plus récent</option>
                    <option value="ASC" <?php if(isset($_GET['date']) && $_GET['date'] == 'ASC') echo 'selected'; ?>>Plus ancien</option>
                </select>
                <input class="filter-input" type="number" name="quantite" min="1" max="100" value="<?php echo isset($_GET['quantite']) && $_GET['quantite'] !== '' ? htmlspecialchars($_GET['quantite']) : 10; ?>" placeholder="Quantité max">
            </div>
            <div class="apply-button-container">
                <button class="apply-button">Appliquer</button>
            </div>
        </form>
    </div>
</div>
<div class="page-container-alert">
    <h2>Alertes produits (quantité basse)</h2>
    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Ville</th>
                    <th>Magasin</th>
                    <th>Groupe</th>
                    <th>Produit</th>
                    <th>Quantité en rayon</th>
                    <th>Date d'expiration</th>
                    <th>Durée avant péremption</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $result): ?>
                <tr <?php if(dureeAvantPeremption($result['date_expiration']) == 'Expiré' || $result['quantite_rayon'] <= 3) echo 'style="background:#ffeaea"'; ?>>
                    <td><?php echo htmlspecialchars($result['ville'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($result['nom_magasin']); ?></td>
                    <td><?php echo htmlspecialchars($result['groupe'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($result['nom_commercial']); ?></td>
                    <td><?php echo htmlspecialchars($result['quantite_rayon']); ?></td>
                    <td><?php echo htmlspecialchars($result['date_expiration']); ?></td>
                    <td><?php echo dureeAvantPeremption($result['date_expiration']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (empty($results)): ?>
            <p style="text-align:center;margin-top:20px;">Aucune alerte produit selon les filtres sélectionnés.</p>
        <?php endif; ?>
    </div>
</div>
