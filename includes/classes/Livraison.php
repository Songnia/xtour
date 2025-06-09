<?php

class Livraison {
    private $conn;
    private $name_table = "Historique_Livraison";

    // Propriétés correspondant aux colonnes de la table Livraison
    public $id_livraison;
    public $code;
    public $produit_id;
    public $nom_produit;
    public $date_fabrication;
    public $date_expiration;
    public $magasin_id;
  
    public $ville;
    public $quantite;
    public $quantite_restante;
    public $date_livraison;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour créer une nouvelle livraison
    public function create() {
        try {
            $query = "INSERT INTO " . $this->name_table 
                   .        " SET code=:code,
                            magasin_id=:magasin_id,
                            ville=:ville";
            $stmt = $this->conn->prepare($query);

            // Liaison des paramètres
            $stmt->bindParam(":code",$this->code);
            $stmt->bindParam(":magasin_id", $this->magasin_id);
            $stmt->bindParam(":ville", $this->ville);

            if ($stmt->execute()) {
                return true;
            }
            error_log($stmt->errorInfo()[2]); // Journaliser l'erreur
            return false;
        } catch (Exception $e) {
            // Gérer l'exception
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            return false;
        }
    }

    public function addProduit($id_livraison) {
        try {
            $query = "INSERT INTO Livraison_Produit 
                      (id_livraison, produit_id, nom_produit, quantite_restante, quantite, date_fabrication, date_expiration) 
                      VALUES 
                      (:id_livraison, :produit_id, :nom_produit, :quantiteR, :quantite, :date_fabrication, :date_expiration)";
            
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(":id_livraison", $id_livraison);
            $stmt->bindParam(":produit_id", $this->produit_id);
            $stmt->bindParam(":nom_produit", $this->nom_produit);
            $stmt->bindParam(":quantiteR", $this->quantite_restante);
            $stmt->bindParam(":quantite", $this->quantite);
            $stmt->bindParam(":date_fabrication", $this->date_fabrication);
            $stmt->bindParam(":date_expiration", $this->date_expiration);
            
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            return false;
        }
    }
    

    // Méthode pour lire toutes les livraisons
    public function read($filter, $params=[], $groupe, $ordre) {
        try {
            $query = "SELECT * FROM ".$this->name_table."  h LEFT JOIN Magasin m ON m.groupe = '".$groupe."' ".$filter." ORDER BY date_livraison ".$ordre;
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Gérer l'exception
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            return false;
        }
    }

    
    public function readLivraisonMagasin($magasin_id) {
        try {
            $query = "SELECT * FROM " . $this->name_table . " WHERE magasin_id = :magasin_id ORDER BY date_livraison DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":magasin_id", $magasin_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Gérer l'exception
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            return false;
        }
    }
    public function getProduit($id_livraison){
      try{
        $query = "SELECT * FROM Livraison_Produit WHERE id_livraison = :id_livraison ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_livraison", $id_livraison);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
        }      
    }

    public function getProduitMagasin($id_produit, $id_livraison){
        try{
          $query = "SELECT * FROM Livraison_Produit WHERE produit_id = :id_produit AND id_livraison = :id_livraison ";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(":id_produit", $id_produit);
          $stmt->bindParam(":id_livraison", $id_livraison);
          $stmt->execute();
  
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
          // Annuler la transaction en cas d'erreur
          error_log($e->getMessage());
          echo "Erreur capturée : " . $e->getMessage();
          return false;
          }      
      }

      public function getProduitMagasinForRapport($id_produit, $id_magasin){
        try{
          $query = "SELECT quantite FROM Livraison_Produit lp
                    LEFT JOIN stocks_produits sp ON lp.produit_id = sp.produit_id 
                    LEFT JOIN Visite v ON v.id_visite =sp.visite_id
                    WHERE lp.produit_id = :id_produit AND v.magasin_id = :id_magasin 
                    ORDER BY quantite DESC;";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(":id_produit", $id_produit);
          $stmt->bindParam(":id_magasin", $id_magasin);
          $stmt->execute();
  
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
          // Annuler la transaction en cas d'erreur
          error_log($e->getMessage());
          echo "Erreur capturée : " . $e->getMessage();
          return false;
          }      
      }


    // Méthode pour mettre à jour une livraison
    public function update() {
        $query = "UPDATE " . $this->name_table . " SET  ville=:ville, date_livraison=:date_livraison WHERE id_livraison = :id";
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":date_livraison", $this->date_livraison);
        $stmt->bindParam(":id", $this->id_livraison);

        if ($stmt->execute()) {
            return true;
        }
        error_log($stmt->errorInfo()[2]); // Journaliser l'erreur
        return false;
    }

    public function updateLivraisonCode($new_code){
      try{
        $query = "UPDATE " . $this->name_table . " SET  code=:code WHERE id_livraison = :id";
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(":code", $new_code);
        $stmt->bindParam(":id", $this->id_livraison);
        return $stmt->execute();

      } catch (Exception $e) {
        // Gérer l'exception
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
    }

    // Méthode pour supprimer une livraison
    public function delete() {
        try {
            $query = "DELETE FROM " . $this->name_table . " WHERE id_livraison = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id_livraison);

            if ($stmt->execute()) {
                return true;
            }
            error_log($stmt->errorInfo()[2]); // Journaliser l'erreur
            return false;
        } catch (Exception $e) {
            // Gérer l'exception
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            return false;
        }
    }

  public function getIDLivraison($new_code){
    try{
      $query = "SELECT id_livraison FROM ".$this->name_table." WHERE code= :code" ;
     
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":code", $new_code);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
  }      
  }
}
?>
