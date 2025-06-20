<?php

class Magasin{
  private $conn;
  private $name_table = "Magasin";

  public $id_magasin;
  public $nom;
  public $ville;
  public $latitude;
  public $longitude;
  public $type;


  public function __construct($db){
    $this->conn = $db;
  }

  public function create() {
    try {
        // Démarrer une transaction
        $this->conn->beginTransaction();

        // Requête SQL
        $query = "INSERT INTO " . $this->name_table . " SET 
                  ville = :ville,
                  nom = :nom,
                  type = :type";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":type", $this->type);
        $stmt->execute();
        // Valider la transaction
        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $this->conn->rollBack();
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
}


  public function read($filter, $params=[], $ordre){
    try{
      $query = "SELECT * FROM ".$this->name_table." ".$filter." ORDER BY date_enregistrement ".$ordre;
      $stmt = $this->conn->prepare($query);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      if ($this->conn->inTransaction()) {
        $this->conn->rollBack();
      }    
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
  }

  }

  public function update(){
    // Concaténer nom et contact du chef magasin
    try{
        $query = "UPDATE ".$this->name_table." SET 
                  ville=:ville,
                  nom=:nom,
                  type=:type, 
                  WHERE id_magasin=:id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":ville",$this->ville);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":id_magasin", $this->id_magasin);
        $stmt->bindParam(":type", $this->type);

        $stmt->execute();
    } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      $this->conn->rollBack();
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
  }

  }

  public function addContact($id_magasin,$role, $name, $phone, $relation){
    // Concaténer nom et contact du chef magasin
    try{   
        $query = "INSERT INTO Contact SET
                  id_magasin=:id_magasin,
                  name=:name,
                  role=:role,
                  phone=:phone,
                  relation=:relation";
      
      $stmt = $this->conn->prepare($query);
      
      // Liaison des paramètres
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':role', $role);
      $stmt->bindParam(':phone', $phone);
      $stmt->bindParam(':relation', $relation);
      $stmt->bindParam(':id_magasin', $id_magasin);
        
      $stmt->execute();
    } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
  }

  }

  public function readContact($id_magasin) {
        $query = "SELECT * FROM Contact WHERE id_magasin = :id_magasin";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_magasin', $id_magasin);
        // Exécution de la requête
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


  public function delete(){
    try{
          $query = "DELETE FROM ".$this->name_table." WHERE id_magasin = ?";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1,$this->id_magasin);
    if($stmt->execute()){
      return true;
    }else{
      return false;
    }
    } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
  }

  }

  public function addProduit($produitName,$id_produit){
    try{
        $query = "INSERT INTO Magasin_Produit (id_produit, id_magasin, produit) VALUES (:id_produit, :id_magasin, :produit)"; 
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_produit", $id_produit);
        $stmt->bindParam(":id_magasin", $this->id_magasin);
        $stmt->bindParam(":produit", htmlspecialchars($produitName));
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }

  }

  public function getProduit($id_magasin){
      try{
        $query = "SELECT * FROM Magasin_Produit WHERE id_magasin = :id_magasin ORDER BY date_ajout DESC";
        $stmt = $this->conn->prepare($query);
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

    public function getProduits($name){
      try{
        $query = "SELECT * FROM Magasin_Produit WHERE nom = :name ORDER BY date_ajout DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }      
    }
    public function deleteProduit($id_produit){
      try{
        $query = "DELETE FROM Magasin_Produit WHERE id_produit = :id_produit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("id_produit", $id_produit);
        $stmt->execute();

        if($stmt->execute()){
          return true;
        }
        error_log($stmt->errorInfo()[2]); // Journaliser l'erreur
        return false;
      } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
  }
    public function getIDMagasin($nom){
      try{
        $query = "SELECT id_magasin FROM Magasin WHERE nom = :nom";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nom", $nom);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }      
    }
    public function getNameMagasin($id_magasin) {
      try {
          $query = "SELECT nom FROM Magasin WHERE id_magasin = :id_magasin";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(":id_magasin", $id_magasin); // Spécifiez le type pour plus de sécurité
          $stmt->execute();
  
          // Récupérer uniquement le nom du magasin
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result ? $result['nom'] : null; // Retourne le nom ou null si aucun résultat

      } catch (Exception $e) {
          // Journaliser l'erreur pour le débogage
          error_log($e->getMessage());
          echo "Erreur capturée : " . $e->getMessage();
          return false;
      }
  }
  
}

?>