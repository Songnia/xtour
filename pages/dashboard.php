<?php $titre = "Dashboard";
  session_start();
  echo "Hello".$_SESSION['nom_utilisateur'];
  include("../includes/sidebar-mobile.php");
  include("../includes/header.php");
?>
  <!-- Sidebar -->
  <?php include("../includes/sidebar.php");
  ?>
  

    <!-- Banner Image -->
    <div class="banner">
      <img src="path/to/banner-image.png" alt="Banner Image"> <!-- Remplacez par le chemin de l'image de bannière -->
    </div>

    <!-- Stat Boxes -->
    <div class="stats">

      <div class="stat-box" onclick="goTomagasin()">
        <span class="stat-icon">🏬</span>
        <h3>20</h3>
        <p>magasins</p>
        <div class="go-corner">
        <a href="../pages/magasin.php"><div class="go-arrow">→</div></a>
        </div>
      </div>

      <div class="stat-box" onclick="goToproduit()">
        <span class="stat-icon">📦</span>
          <h3>12</h3>
          <p>produits</p>
          <div class="go-corner">
          <a href="../pages/produit.php"><div class="go-arrow">→</div></a>
          </div>
      </div>

      <div class="stat-box" onclick="goTolivraison()">
        <span class="stat-icon">📄</span>
        <h3>12</h3>
        <p>Livraison</p>
        <div class="go-corner">
            <a href="#"><div class="go-arrow">→</div></a>
        </div>
      </div>

      <div class="stat-box" onclick="goTotournee()">
        <span class="stat-icon">📊</span>
        <h3>125</h3>
        <p>Tournées</p>
        <div class="go-corner">
        <a href="../pages/rapport.php"><div class="go-arrow">→</div></a>
        </div>
      </div>
    </div>

    <!-- Table Section -->
    <div class="container-scroll">
      <div class="table-section">
        <h2>Title of table</h2>
        <table>
          <thead>
            <tr>
              <th>Title of table</th>
              <th>Title of table</th>
              <th>Title of table</th>
              <th>Title of table</th>
              <th>Title of table</th>
              <th>Title of table</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>12</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
            </tr>
            <tr>
              <td>12</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
            </tr>
            <tr>
              <td>12</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
            </tr>
            <tr>
              <td>12</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
            </tr>
            <tr>
              <td>12</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
            </tr>
            <tr>
              <td>12</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
              <td>Data</td>
            </tr>
            <!-- Ajoutez d'autres lignes si nécessaire -->
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
  

