<?php
  // Méthode pour récupérer la dernière valeur non nulle de `quantite_rayon`
   function getLastQuantiteRayon($db) {
    global $db;
    try{
      $query = "SELECT quantite_rayon
                    FROM stocks_produits
                    WHERE quantite_rayon > 0
                    ORDER BY id_stock DESC
                    LIMIT 1";
  echo"hello0";
  $stmt = $db->prepare($query);
  $stmt->execute();
  $qt_rayon = $stmt->fetch(PDO::FETCH_ASSOC);
  $qt_rayon = $qt_rayon ? $qt_rayon['quantite_rayon'] : 0;
  } catch (Exception $e) {
      // Journaliser l'erreur pour le débogage
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
  }
}
?>