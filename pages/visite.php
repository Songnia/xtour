<link rel="icon" type="image/png" sizes="32x32" href="Visimags-carre1.png">
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
include_once("../includes/classes/User.php");
include_once("../includes/classes/Tournee.php");
$database = new Database();
$db = $database->getConnection();

$magasin = new Magasin($db);
$produit = new Produit($db);
$tour = new Tour($db);
$prods = $produit->read();

// Après la connexion à la base de données et avant les autres requêtes


// Récupération des informations sur la tournée et les magasins
try {
    // Initialiser les variables
    $tournee_info = null;
    $magasins_tournee = [];
    $magasin_actuel = null;
    $magasin_precedent = null;
    $magasin_suivant = null;
    $produits_visites = [];
    $codeTournee = "";
    
    // Récupérer le code de tournée
    if(isset($_GET['codeTournee']) && !empty($_GET['codeTournee'])) {
        $codeTournee = $_GET['codeTournee'];
    } 
    // Récupérer le code de tournée
      if(isset($_GET['villeMagasin']) && !empty($_GET['villeMagasin'])) {
        $ville = $_GET['villeMagasin'];
      } 
    // Récupérer l'ID du magasin
    $magasin_id = null;
    if(isset($_GET['nomMagasin']) && !empty($_GET['nomMagasin'])) {
      $nom_magasin = $_GET['nomMagasin'];
      $id_magasin = $magasin->getIDMagasin($nom_magasin);
      $magasin_id = $id_magasin['id_magasin'];
    }

    //Recuperer le type de la tournee
    if(isset($_GET['typeTournee'])) {
        $type = $_GET['typeTournee'];
    } else {
        $type = 1; // Remplacez par la valeur par défaut souhaitée si nécessaire
    }
 

    // Si nous avons un code de tournée, procéder
    if(!empty($codeTournee)) {
        // Récupérer les informations de la tournée (en utilisant les bonnes colonnes)
        $query_tournee = "SELECT *
                          FROM Tour 
                          WHERE code_tournee = ? AND nom_magasin = ?";
        $stmt = $db->prepare($query_tournee);
        $stmt->execute([$codeTournee, $nom_magasin]);
        $tournee_info = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($tournee_info);

        if($tournee_info) {
            // Si nous avons des magasins
            if(!empty($tournee_info['id_tour'])) {
                // récupérer les statistiques du magasin
                    // Récupérer l'ID du magasin à partir de son nom
                    if($magasin_id) {
                        // Nombre total de produits
                        $q_total = "SELECT COUNT(*) as total FROM Visite WHERE magasin_id = ? AND codeTournee = ?";
                        $stmt = $db->prepare($q_total);
                        $stmt->execute([$magasin_id, $codeTournee]);
                        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                        
                        // Nombre de produits vérifiés
                        $q_verifies = "SELECT COUNT(*) as verifies FROM Visite WHERE magasin_id = ? AND codeTournee = ? AND statue = 1";
                        $stmt = $db->prepare($q_verifies);
                        $stmt->execute([$magasin_id, $codeTournee]);
                        $verifies = $stmt->fetch(PDO::FETCH_ASSOC)['verifies'];
                        
                        // Ajouter au tableau des magasins
                        $statistique_magasin[] = array_merge( [
                            'nom_magasin' => $nom_magasin,
                            'magasin_id' => $magasin_id,
                            'total_produits' => $total,
                            'produits_verifies' => $verifies
                        ]);
                    }           
                // Déterminer le magasin actuel
                  $magasin_actuel = $statistique_magasin[0];
                // Si un magasin est sélectionné, récupérer ses produits
                if($magasin_actuel) {
                    $query_produits = "SELECT id_produit, produit FROM Magasin_Produit WHERE id_magasin = ?;
";
                    
                    $stmt = $db->prepare($query_produits);
                    $stmt->execute([$magasin_id]);
                    $produits_visites = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // Mettre à jour $resultas pour compatibilité
                    if(!empty($produits_visites)) {
                        $resultas['ville'] = $ville;
                        $resultas['nom_magasin'] = $magasin_actuel['nom_magasin'];
                        $resultas['codeTournee'] = $codeTournee;
                    }

                }
            }
        }
    }
} catch(Exception $e) {
    error_log($e->getMessage());
    echo "Erreur lors de la récupération des informations : " . $e->getMessage();
    
    // Initialiser des valeurs par défaut
}

// Définir $visite_actuelle si elle n'existe pas
if (!isset($visite_actuelle)) {
    $visite_actuelle = [];
    // Si nous avons un magasin actuel, l'utiliser pour initialiser $visite_actuelle
    if ($magasin_actuel) {
        $visite_actuelle['magasin_id'] = $magasin_actuel['magasin_id'];
        $visite_actuelle['ville'] = $ville;
        $visite_actuelle['nom_magasin'] = $magasin_actuel['nom_magasin'];
        $visite_actuelle['codeTournee'] = $codeTournee;
    }
}

// Utiliser les données de visite_actuelle pour les requêtes suivantes
$resultas = $visite_actuelle;



try{
    // Requête sécurisée avec paramètres bindés
    $query ="SELECT COUNT(sp.produit_id) as nb_produit_visite FROM stocks_produits sp 
             LEFT JOIN Visite v ON v.id_visite = sp.visite_id 
             WHERE v.codeTournee = :code AND v.magasin_id = :magasin_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":code", $codeTournee);
    $stmt->bindParam(":magasin_id", $magasin_actuel['magasin_id']);
    $stmt->execute();

    $ress_count = $stmt->fetch(PDO::FETCH_ASSOC);

    // Requête pour obtenir le nombre total de produits dans le magasin
    $query1 ="SELECT COUNT(id_produit) as nb_produit_magasin FROM Magasin_Produit WHERE id_magasin = :id_magasin";
    $stmt = $db->prepare($query1);
    $stmt->bindParam(":id_magasin", $resultas['magasin_id']);
    $stmt->execute();
    $res_count = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtenir la liste des produits déjà vérifiés
    $query2 = "SELECT sp.produit_id, p.nom_commercial 
               FROM stocks_produits sp 
               LEFT JOIN Visite v ON v.id_visite = sp.visite_id 
               LEFT JOIN Produit p ON p.id_produit = sp.produit_id
               WHERE v.codeTournee = :code AND v.magasin_id = :magasin_id";
    $stmt = $db->prepare($query2);
    $stmt->bindParam(":code", $codeTournee );
    $stmt->bindParam(":magasin_id", $magasin_actuel['magasin_id'] );
    $stmt->execute();
    
    $produits_verifies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Erreur capturée : " . $e->getMessage();
    return false;
}
/*echo "////////////////////////////////////////////////////////////////////////////////////////////////////////";
echo "<pre>";
var_dump($res_count);
echo "</pre>";*/

// Calcul du pourcentage de progression
$total_produits = (int)$res_count["nb_produit_magasin"];
$nombre_produits_visites = (int)$ress_count["nb_produit_visite"];
$pourcentage_progression = ($total_produits > 0) ? round(($nombre_produits_visites / $total_produits) * 100) : 0;
//var_dump(value: $total_produits,$nombre_produits_visites, $pourcentage_progression);
$display = "none";
if($nombre_produits_visites === $total_produits && $total_produits > 0){
    $display = "flex";
    try{
        $query = "UPDATE Visite SET statue = 1 WHERE id_visite = :id_visite";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id_visite", $resultas['id_visite']);
        if ($stmt->execute()) {
            // Visite marquée comme terminée
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
}

$required = 0;
$quik_tour = $type;
echo "Type: ".$quik_tour;
if($quik_tour == 1){
    echo '<style>
            .champ-invisible { display: none; }
        </style>';
}
?>
<!-- Page Content -->
<main class="container">
        <!-- <h1>Tournées</h1> Ajouter juste après <main class="container"> -->
<div class="tournee-navigation">
    <?php if(isset($tournee_info) && $tournee_info): ?>
        <div class="tournee-header">
            <h1>Tournée : <?php echo htmlspecialchars($tournee_info['code_tournee']); ?></h1>
            <div class="tournee-metadata">
                <!--<p><strong>Date:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($tournee_info['date']))); ?></p>
                <p><strong>Jour:</strong> <?php echo htmlspecialchars($tournee_info['jour']); ?></p>
                <p><strong>Objectif:</strong> <?php echo htmlspecialchars($tournee_info['Objectif']); ?></p>
                <p><strong>Statut:</strong> 
                    <span class="status-badge status-<?php echo strtolower($tournee_info['statut']); ?>">
                        <?php echo htmlspecialchars($tournee_info['statut']); ?>
                    </span>
                </p>-->
            </div>
        </div>
        
        <?php if(isset($magasin_actuel) && $magasin_actuel): ?>
            <div class="magasin-info">
                <div class="magasin-details">
                    <h2>Magasin actuel</h2>
                    <p><strong>Nom :</strong> <?php echo htmlspecialchars($magasin_actuel['nom_magasin']); ?></p>
                    <p><strong>Ville :</strong> <?php echo htmlspecialchars($ville); ?></p>                    
                <div class="progression-container">
                    <h3>Progression de la visite</h3>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: <?php echo $pourcentage_progression; ?>%;">
                            <span><?php echo $pourcentage_progression; ?>%</span>
                        </div>
                    </div>
                    <div class="progress-details">
                        <p>Produits vérifiés : <?php echo $nombre_produits_visites; ?> sur <?php echo $total_produits; ?></p>
                    </div>
                    
                    <?php if (!empty($produits_verifies)): ?>
                    <div class="produits-verifies">
                        <h4>Produits déjà vérifiés :</h4>
                        <ul>
                            <?php foreach ($produits_verifies as $produit): ?>
                                <li><?php echo htmlspecialchars($produit['nom_commercial'] ?? $produit['produit_id']); ?> ✅</li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <!--
                <div class="navigation-controls">
                    <?php if($magasin_precedent): ?>
                        <a href="visite.php?magasin_id=<?php echo $magasin_precedent['magasin_id']; ?>&codeTournee=<?php echo urlencode($codeTournee); ?>" class="nav-button prev-button">
                            <i class="fas fa-arrow-left"></i> Magasin précédent<br>
                            <span class="small"><?php echo htmlspecialchars($magasin_precedent['nom_magasin']); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if($magasin_suivant): ?>
                        <a href="visite.php?magasin_id=<?php echo $magasin_suivant['magasin_id']; ?>&codeTournee=<?php echo urlencode($codeTournee); ?>" class="nav-button next-button">
                            Magasin suivant <i class="fas fa-arrow-right"></i><br>
                            <span class="small"><?php echo htmlspecialchars($magasin_suivant['nom_magasin']); ?></span>
                        </a>
                    <?php endif; ?> 
                </div>
            </div>-->
            
            <!-- Afficher la progression globale de la tournée 
            <div class="tournee-progress">
                <h3>Progression de la tournée</h3>
                
                <?php 
                $total_produits_tournee = 0;
                $produits_verifies_tournee = 0;
                $magasins_completes = 0;
                
                foreach($magasins_tournee as $index => $magasin): 
                    $total_produits_tournee += $magasin['total_produits'];
                    $produits_verifies_tournee += $magasin['produits_verifies'];
                    
                    if($magasin['produits_verifies'] == $magasin['total_produits'] && $magasin['total_produits'] > 0) {
                        $magasins_completes++;
                    }
                endforeach;
                
                $pourcentage_global = ($total_produits_tournee > 0) ? 
                    ($produits_verifies_tournee / $total_produits_tournee) * 100 : 0;
                ?>
                
                <div class="tournee-summary">
                    <div class="stat-box">
                        <span class="stat-value"><?php echo $magasins_completes; ?>/<?php echo count($magasins_tournee); ?></span>
                        <span class="stat-label">Magasins complétés</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-value"><?php echo $produits_verifies_tournee; ?>/<?php echo $total_produits_tournee; ?></span>
                        <span class="stat-label">Produits vérifiés</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-value"><?php echo round($pourcentage_global); ?>%</span>
                        <span class="stat-label">Progression globale</span>
                    </div>
                </div>
                
                <div class="magasins-list">
                    <h4>Liste des magasins de la tournée</h4>
                    <?php foreach($magasins_tournee as $index => $magasin): 
                        $pourcentage = ($magasin['total_produits'] > 0) ? 
                            ($magasin['produits_verifies'] / $magasin['total_produits']) * 100 : 0;
                            
                        $status_class = '';
                        if($magasin['produits_verifies'] == $magasin['total_produits'] && $magasin['total_produits'] > 0) {
                            $status_class = 'completed';
                        } elseif($magasin['produits_verifies'] > 0) {
                            $status_class = 'in-progress';
                        } else {
                            $status_class = 'not-started';
                        }
                    ?>
                        <a href="visite.php?magasin_id=<?php echo $magasin['magasin_id']; ?>&codeTournee=<?php echo urlencode($codeTournee); ?>" 
                           class="magasin-item <?php echo ($magasin['magasin_id'] == $magasin_actuel['magasin_id']) ? 'current' : ''; ?> <?php echo $status_class; ?>">
                            <div class="magasin-name">
                                <?php echo $index + 1; ?>. <?php echo htmlspecialchars($magasin['nom_magasin']); ?>
                                <span class="magasin-counter"><?php echo $magasin['produits_verifies']; ?>/<?php echo $magasin['total_produits']; ?></span>
                            </div>
                            <div class="progress-small">
                                <div class="progress-bar-small" style="width: <?php echo $pourcentage; ?>%"></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                
                <div class="progress-global">
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: <?php echo $pourcentage_global; ?>%;">
                            <span><?php echo round($pourcentage_global); ?>%</span>
                        </div>
                    </div>
                    <div class="progress-text">
                        <?php echo $produits_verifies_tournee; ?> sur <?php echo $total_produits_tournee; ?> produits vérifiés au total
                    </div>
                </div>
            </div>
            
             Lite des produits du magasin actuel 
            <?php if(!empty($produits_visites)): ?>
                <div class="produits-magasin">
                    <h3>Produits à vérifier dans ce magasin</h3>
                    <div class="produits-filter">
                        <button class="filter-btn active" data-filter="all">Tous</button>
                        <button class="filter-btn" data-filter="checked">Vérifiés</button>
                        <button class="filter-btn" data-filter="unchecked">À vérifier</button>
                    </div>
                    <table class="produits-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>État</th>
                                <th>Date Exp.</th>
                                <th>Qté Rayon</th>
                                <th>Qté Stock</th>
                                <th>Prix</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($produits_visites as $produit): 
                                $row_class = ($produit['statue'] == 1) ? 'produit-verifie' : 'produit-a-verifier';
                            ?>
                                <tr class="<?php echo $row_class; ?>">
                                    <td><?php echo htmlspecialchars($produit['nom_produit'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="etat-badge etat-<?php echo strtolower($produit['etat'] ?? 'inconnu'); ?>">
                                            <?php echo htmlspecialchars($produit['etat'] ?? 'N/A'); ?>
                                        </span>
                                    </td>
                                    <td><?php echo isset($produit['date_expiration']) ? htmlspecialchars(date('d/m/Y', strtotime($produit['date_expiration']))) : 'N/A'; ?></td>
                                    <td><?php echo htmlspecialchars($produit['quantite_rayon'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($produit['quantite_stock'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($produit['prix'] ?? 'N/A'); ?> FCFA</td>
                                    <td>
                                        <span class="status-dot <?php echo ($produit['statue'] == 1) ? 'verified' : 'pending'; ?>"></span>
                                        <?php echo ($produit['statue'] == 1) ? 'Vérifié' : 'À vérifier'; ?>
                                    </td>
                                    <td>
                                        <a href="#" class="action-btn view-btn" data-id="<?php echo $produit['id_visite']; ?>">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="action-btn edit-btn" data-id="<?php echo $produit['id_visite']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>-->
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucun produit n'a encore été enregistré pour ce magasin dans cette tournée.
                    <div class="alert-actions">
                        <a href="#verif" class="btn btn-primary">Ajouter un produit maintenant</a>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Aucun magasin trouvé pour cette tournée. Veuillez ajouter des magasins à cette tournée.
                <div class="alert-actions">
                    <a href="magasin.php" class="btn btn-primary">Gérer les magasins</a>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Aucune tournée trouvée avec ce code. Veuillez vérifier le code de tournée.
            <div class="alert-actions">
                <a href="tournee.php" class="btn btn-primary">Retour aux tournées</a>
            </div>
        </div>
    <?php endif; ?>
</div>
        <form id="productForm" method="POST" enctype="multipart/form-data" action="../includes/classes/enregistrerVisite.php" enctype="multipart/form-data">
            <!-- Vérification générale -->
             <input type="hidden" name="codeTournee" value="<?php echo $codeTournee; ?>">
             <input type="hidden" name="type" value="<?php echo $quik_tour ?>">
            <section class="section">
                <h2 id="verif">Vérification générale</h2>

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
                                <option value="<?php echo htmlspecialchars($res['nom']); ?>" 
                                        <?php if (isset($magasin_actuel['nom_magasin']) && $magasin_actuel['nom_magasin'] == $res['nom']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($res['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select> 
                    </div>  
                    <?php //var_dump($produits_visites); 
                        // Amélioration de la requête pour obtenir les produits vérifiés
                        try{
                        $query2 = "SELECT DISTINCT p.id_produit, p.nom_commercial,
                                   MAX(v.statue) as statue
                                   FROM Produit p
                                   JOIN Magasin_Produit mp ON p.id_produit = mp.id_produit
                                   LEFT JOIN Visite v ON (v.magasin_id = mp.id_magasin AND v.codeTournee = :code)
                                   WHERE mp.id_magasin = :magasin_id
                                   GROUP BY p.id_produit, p.nom_commercial
                                   ORDER BY statue DESC, p.nom_commercial";
                            $stmt = $db->prepare($query2);
                            $stmt->bindParam(":code", $code);
                            $stmt->bindParam(":magasin_id", $resultas['magasin_id']);
                            $stmt->execute();
                        } catch (Exception $e) {
                            error_log($e->getMessage());
                            echo "Erreur capturée : " . $e->getMessage();
                            return false;
                        }


                        $tous_produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        echo "<pre>";
                            //var_dump($produits_verifies);
                        echo "</pre>";
                        // Créer un tableau séparé pour les produits vérifiés
                        echo "<pre>";
                            //var_dump($produits_verifies);
                        echo "</pre>";
                    ?>
                    <div class="question">
                    <label for="product">Produit</label>
                    <select id="product" name="product" <?php  echo ($require==1)? "required" : ""; ?> >
                    <?php if (!empty($tous_produits)): ?>
                    <?php foreach ($tous_produits as $produit): ?>
                        <?php 
                            foreach ($produits_verifies as $produitv) {
                            $check = ($produit['statue'] == 1) ? " ✅" : "";
                            $classe = ($produit['statue'] == 1) ? " class='produit-verifie'" : "";
                            }
                            // Détermine si le produit est déjà vérifié (statue = 1)
                            
                        ?>
                        <option value="<?php echo htmlspecialchars($produit['id_produit']); ?>"<?php echo $classe; ?>>
                            <?php echo htmlspecialchars($produit['nom_commercial']) . $check; ?>
                        </option>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <option value="">-- Aucun produit disponible --</option>
                    <?php endif; ?>
                    </select>
                    </div>

                    <!-- ... existing code ... -->

                    <?php if (!empty($produits_verifies)): ?>
                    <div class="produits-verifies">
                    <h4>Produits déjà vérifiés :</h4>
                    <ul>
                    <?php foreach ($produits_verifies as $produit): ?>
                    <li><?php echo htmlspecialchars($produit['nom_commercial'] ?? $produit['id_produit']); ?> ✅</li>
                    <?php endforeach; ?>
                    </ul>
                    </div>
                    <?php endif; ?>

                    <!-- ... existing code ... -->

                    <div class="question champ-invisible">
                        <p>le produit a t-il un bon emplacement et est bien visible ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="visibiliter" value="yes" <?php  echo ($require==1)? "required" : ""; ?> > Oui</label>
                            <label><input type="radio" name="visibiliter" value="no" <?php  echo ($require==1)? "required" : ""; ?> > Non</label>
                        </div>
                    </div>

                    <div class="question champ-invisible">
                        <p>Est ce que l'étiquette correspond à l'emplacement du produit ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="etiquette" value="yes" <?php  echo ($require==1)? "required" : ""; ?> > Oui</label>
                            <label><input type="radio" name="etiquette" value="no" <?php  echo ($require==1)? "required" : ""; ?> > Non</label>
                        </div>
                    </div>

                    <div class="champ-invisible">
                        <p>Quel est le prix sur l'etiquette du produit ?</p>
                        <input type="number" name="prix" placeholder="prix..." class="prix">
                    </div>

                     <div id="espace">
                        <hr>
                     </div>

                    <!--<div class="infoProduit" class="question">
                        <label for="etat">État du Produit</label>
                        <select id="etat" name="etat" <?php  echo ($require==1)? "required" : ""; ?> >
                            <option value="bon">Bon</option>
                            <option value="moyen">Moyen</option>
                            <option value="mauvais">Mauvais</option>
                        </select>
                    </div> -->

                    <div class="question champ-invisible">
                    <p>Quel est L'État du Produit ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="etat" value="bon" > bon</label>
                            <label><input type="radio" name="etat" value="moyen" > moyen</label>
                            <label><input type="radio" name="etat" value="mauvais" > mauvais</label>
                        </div>
                    </div>

                    <div class="stock-info question champ-invisible">
                        <div class="infoProduit">
                            <label for="dateFab">Date de fabrication</label>
                            <input type="date" id="dateFab" name="dateFab" <?php  echo ($require==1)? "required" : ""; ?> >
                        </div>
                        <div class="infoProduit">
                            <label for="dateExp">Date d'expiration</label>
                            <input type="date" id="dateExp" name="dateExp" <?php  echo ($require==1)? "required" : ""; ?> >
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
                        
                        <div class="question champ-invisible">
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

                    <div class="question champ-invisible" style="margin-bottom:10px,margin-top:40px">
                        <p>Les vendeurs connaissent l'emplacement des produits ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="emplacement" value="yes" <?php  echo ($require==1)? "required" : ""; ?> > Oui</label>
                            <label><input type="radio" name="emplacement" value="no" <?php  echo ($require==1)? "required" : ""; ?> > Non</label>
                        </div>
                    </div>


                    <div class="question champ-invisible">
                        <p>Le magasin a t-il une promotrice ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="existance_promotrice" value="yes" oninput="openPromotrice()" <?php  echo ($require==1)? "required" : ""; ?> > Oui</label>
                            <label><input type="radio" name="existance_promotrice" value="no" <?php  echo ($require==1)? "required" : ""; ?>  oninput="hiddenPromotrice()"> Non</label>
                        </div>
                    </div>

                    <div class="question champ-invisible" id="promotrice">
                        <p>La promotrice est elle presente ?</p>
                        <div class="reponse">
                            <label><input type="radio" name="presence_promotrice" value="yes" > Oui</label>
                            <label><input type="radio" name="presence_promotrice" value="no" > Non</label>
                        </div>
                    </div>


                    <!--<div class="question">
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
                    </div> -->

                    <div class="question champ-invisible">
                        <p>Feedbacks</p>
                        <div class="reponse">
                            <label><input type="radio" name="feedback_value" value="Non Connu" > NC</label>
                            <label style="min-width:114.13"><input type="radio" name="feedback_value" value="bon" > bon</label>
                        </div>
                    </div>
                    <div class="question champ-invisible" >
                        <div class="reponse">
                            <label style="min-width:114.13"><input type="radio" name="feedback_value" value="Moyen" > Moyen</label>
                            <label><input type="radio" name="feedback_value" value="Mauvais" > Mauvais</label>
                        </div>
                    </div>
                    <textarea id="feedback" class="champ-invisible" name="decription" placeholder="Feedback..."></textarea>                        

                </section>

                <!-- Gestion des stocks -->
                <section class="section">
                <!--<h2>Gérer les stocks</h2>-->
                <hr>
                
                <section class="section">
                        <label for="imageUpload">Importer les images</label>
                        <label class="custum-file-upload" for="imageFile">
                            <svg id="svgImage" xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                            <img id="imagePreview" src="" alt="preview Image" style="width:100px; height:100px;display:none" >
                            <div class="text">                            <div>

                                <span>Click to upload image</span>
                            </div>
                            <input type="file" id="imageFile" name="image" onchange="previewImage()" >
                       </label>
                </section>
            </section>


            <!-- Bouton de soumission -->
            <button type="submit" class="submit-btn">Enregistrer</button>
        </form> 
        <?php include("../includes/footer.php"); ?>
    </main>
        
    <div id="nextVisitModal" class="modal" style="display:<?php echo $display; ?>">
    <div class="modal-content">
        <span class="close-button2" onclick="closeModal()">&times;</span>
        <h2>Visite</h2>
            <div>
                <span for="">Vous venez de terminer cette visite,</span>
                <span for="">passer au magasin suivant.</span>
            </div>
            <button id="goToPlanification" class="btn btn-green" style="margin:10px 0; width:100%" onclick="goTotournee1()" >Next</button>
    </div>
    </div> 



    <script>
    function closeModal() {
        document.getElementById('nextVisitModal').style.display = 'none';
    }

    

    // Mise à jour automatique de la progression lors de la sélection d'un produit
    document.getElementById('product').addEventListener('change', function() {
        // Ici on pourrait ajouter du code AJAX pour enregistrer chaque produit vérifié en temps réel
        // et mettre à jour la barre de progression sans recharger la page
    });

    // Si tous les produits sont vérifiés, afficher la modal automatiquement
    window.onload = function() {
        if (<?php echo $pourcentage_progression; ?> === 100) {
            document.getElementById('nextVisitModal').style.display = 'flex';
        }
    };
    </script>

    <!-- Ajouter après les autres inclusions CSS -->
    <style>
    .progression-container {
        margin: 20px 0;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .progress-bar-container {
        width: 100%;
        height: 25px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        margin: 10px 0;
    }

    .progress-bar {
        height: 100%;
        background-color: #28a745;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: width 0.5s ease;
    }

    .progress-details {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }

    .produits-verifies {
        margin-top: 15px;
    }

    .produits-verifies ul {
        list-style-type: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .produits-verifies li {
        background-color: #e8f4e8;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 14px;
    }

    .progress-small {
        height: 5px;
        background-color: rgba(0,0,0,0.1);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar-small {
        height: 100%;
        background-color: rgba(255,255,255,0.7);
    }

    .progress-global {
        margin-top: 15px;
    }

    .progress-bar-container {
        width: 100%;
        height: 25px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        margin: 10px 0;
    }

    .progress-bar {
        height: 100%;
        background-color: #28a745;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: width 0.5s ease;
    }

    .progress-text {
        text-align: center;
        font-size: 14px;
        color: #555;
    }

    .produits-magasin {
        margin-top: 20px;
    }

    .produits-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .produits-table th, .produits-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .produits-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .produit-verifie {
        background-color: rgba(46, 204, 113, 0.2);
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        color: #856404;
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
    }

    .alert-warning {
        color: #856404;
        background-color: #fff3cd;
        border-color: #ffeeba;
    }

    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        text-decoration: none;
    }

    .btn-primary {
        color: #fff;
        background-color: #3498db;
        border-color: #3498db;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    .tournee-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .tournee-metadata {
        display: flex;
        gap: 20px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-en_cours {
        background-color: #ffeeba;
        color: #856404;
    }
    
    .status-completee {
        background-color: #c3e6cb;
        color: #155724;
    }
    
    .status-planifiee {
        background-color: #b8daff;
        color: #004085;
    }
    
    .tournee-summary {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }
    
    .stat-box {
        background-color: #fff;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        flex: 1;
        margin: 0 10px;
    }
    
    .stat-value {
        display: block;
        font-size: 24px;
        font-weight: bold;
        color: #3498db;
    }
    
    .stat-label {
        display: block;
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }
    
    .magasins-list {
        margin: 20px 0;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .magasin-item {
        display: block;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: white;
        text-decoration: none;
        color: #333;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
    
    .magasin-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .magasin-item.current {
        border-left: 4px solid #3498db;
        background-color: #e8f4fd;
    }
    
    .magasin-item.completed {
        border-left: 4px solid #2ecc71;
    }
    
    .magasin-item.in-progress {
        border-left: 4px solid #f39c12;
    }
    
    .magasin-item.not-started {
        border-left: 4px solid #95a5a6;
    }
    
    .magasin-counter {
        float: right;
        background-color: #f1f1f1;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
    }
    
    .produits-filter {
        margin-bottom: 15px;
    }
    
    .filter-btn {
        background-color: #f8f9fa;
        border: none;
        padding: 8px 15px;
        border-radius: 20px;
        margin-right: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .filter-btn.active {
        background-color: #3498db;
        color: white;
    }
    
    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    .status-dot.verified {
        background-color: #2ecc71;
    }
    
    .status-dot.pending {
        background-color: #f39c12;
    }
    
    .etat-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
    }
    
    .etat-bon {
        background-color: #d4edda;
        color: #155724;
    }
    
    .etat-moyen {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .etat-mauvais {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .action-btn {
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        margin: 0 3px;
    }
    
    .view-btn {
        background-color: #e9ecef;
        color: #495057;
    }
    
    .edit-btn {
        background-color: #e9ecef;
        color: #495057;
    }
    
    .magasin-progress {
        height: 10px;
        margin-top: 5px;
    }
    
    .nav-button {
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        margin: 0 5px;
        transition: all 0.2s;
    }
    
    .nav-button:hover {
        background-color: #e9ecef;
    }
    
    .next-button {
        margin-left: auto;
    }
    
    .alert-actions {
        margin-top: 10px;
    }
</style>

<!-- Script pour le filtrage des produits dans le tableau -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage des produits
    const filterButtons = document.querySelectorAll('.filter-btn');
    const produitRows = document.querySelectorAll('.produits-table tbody tr');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Supprimer la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            produitRows.forEach(row => {
                if (filter === 'all') {
                    row.style.display = '';
                } else if (filter === 'checked' && row.classList.contains('produit-verifie')) {
                    row.style.display = '';
                } else if (filter === 'unchecked' && row.classList.contains('produit-a-verifier')) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>
</body>
</html>
