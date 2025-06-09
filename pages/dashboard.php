<link rel="icon" type="image/png" sizes="32x32" href="Visimags-carre1.png">
<?php $titre = "Dashboard";
  session_start();
  include_once("../includes/classes/Database.php");
  include_once("../includes/classes/Magasin.php");
  include_once("../includes/classes/Produit.php");

  $database = new Database();
  $db = $database->getConnection();
  $magasin = new Magasin($db);
  $produit = new Produit($db);

  include("../includes/sidebar-mobile.php");
  
  include("../includes/header.php");
?>

  <!-- Sidebar -->
  <?php include("../includes/sidebar.php");
  ?>
  

    <!-- Banner Image -->
    <div class="banner">
      <h1>
        Industrie Africaine <br>
        <span style="color: #d8d95f">de la graine <br>de courge</span>
      </h1>
      <img src="../assets/logoNgon.png" alt="Banner Image"> <!-- Remplacez par le chemin de l'image de bannière -->
    </div>

    <!-- Stat Boxes -->
    <div class="stats">

      <div class="stat-box" onclick="goTomagasin()">
        <span class="stat-icon">🏬</span>
        <h3>20</h3>
        <p>magasins</p>
        <div class="go-corner">
        <div class="go-arrow">→</div>
        </div>
      </div>

      <div class="stat-box" onclick="goToproduit()">
        <span class="stat-icon">📦</span>
          <h3>12</h3>
          <p>produits</p>
          <div class="go-corner">
          <div class="go-arrow">→</div>
          </div>
      </div>

      <div class="stat-box" onclick="goTolivraison()">
        <span class="stat-icon">📄</span>
        <h3>12</h3>
        <p>Livraison</p>
        <div class="go-corner">
          <div class="go-arrow">→</div>
        </div>
      </div>

      <div class="stat-box" onclick="goTotournee()">
        <span class="stat-icon">📊</span>
        <h3>125</h3>
        <p>Tournées</p>
        <div class="go-corner">
        <div class="go-arrow">→</div>
        </div>
      </div>
    </div>
<?php

try{
  //echo "ID magasin: ".$maga['id_magasin']."  :id P ".$prodm['id_produit'];
  $query = "SELECT codeTournee FROM  Visite ORDER BYcodeTournee ASC;";
  $stmt = $db->prepare($query); // Correction ici
  $stmt->execute();
  $lasts_visite = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
}
echo"<pre>";
  var_dump($lasts_visite);
echo"</pre>";
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
      WHERE v.codeTournee = '".$lasts_visite['codeTournee']."';
  ";
  
  $stmt = $db->prepare($query);
  $stmt->execute($params);

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
    <h3>Derniere Tournee</h3>
    <!-- Table Section -->
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
    <button id="addButton"></button>
    <?php /*<script>
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.getElementById("sidebarMobile");
        const closesidebar = document.getElementById("closesidebarMobile");

        menuToggle.addEventListener("click", () => {
        sidebar.style.right = "0"; // Affiche la sidebar en la ramenant à droite de l'écran
        });
//❌❌❌❌❌ les utilisateurs seron❌❌❌❌t rediriger vers la page❌❌❌❌ des tournee en fonction de leur type ❌❌❌❌❌ en Php
include("../includes/sidebar-mobile-com.php");
        closesidebar.addEventListener("click", () => {
        sidebar.style.right = "-100%"; // Cache la sidebar en la renvoyant hors de l'écran
        });
        window.addEventListener("click", (event) => {
        if (event.target === sidebar) {
            sidebar.style.right = "-100%";}
        });
      </script> */?>
    <?php include("../includes/footer.php"); ?>
  </main>
  

