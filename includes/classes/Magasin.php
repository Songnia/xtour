<?php

class Magasin{
  private $conn;
  private $name_table = "Magasin";
  private $contacts_table = "MagasinContacts";


  public $id_magasin;
  public $nom;
 // public $ville;
  public $latitude;
  public $longitude;
  public $chefMagasinName;
  public $contactChef;
  public $type;
  public $contacts;
  public function __construct($db){
    $this->conn = $db;
  }

  public function create($contacts = []) {
    try {
        // Préparer les contacts concaténés
        $contactsConcat = [];
        foreach ($contacts as $contact) {
            $contactsConcat[] = $contact['name'] . ": " . $contact['contact'];
        }
        $contactsString = implode("; ", $contactsConcat);

        // Concaténer nom et contact du chef magasin
        $chefMagasin = $this->chefMagasinName . " | " . $this->contactChef;

        // Démarrer une transaction
        $this->conn->beginTransaction();

        // Requête SQL
        $query = "INSERT INTO " . $this->name_table . " SET 
                  nom = :nom,
                  type = :type,
                  chef_magasin = :chef_magasin,
                  contacts = :contacts";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":chef_magasin", $chefMagasin); // Correctement aligné avec la requête SQL
        $stmt->bindParam(":contacts", $contactsString);

        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de la création du magasin : " . implode(" | ", $stmt->errorInfo()));
        }

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


  public function read(){
    $query = "SELECT * FROM ".$this->name_table." ORDER BY date_enregistrement DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function update($contacts = []){
    $contactsConcat = [];
    foreach ($contacts as $contact) {
        $contactsConcat[] = $contact['name'] . ": " . $contact['contact'];
    }
    $contactsString = implode("; ", $contactsConcat);

    // Concaténer nom et contact du chef magasin
    $chefMagasin = $this->chefMagasinName . " | " . $this->contactChef;


    $query = "UPDATE ".$this->name_table." SET 
              nom=:nom,
              latitude=:latitude, 
              longitude=:longitude, 
              chef_magasin=:chef_magasin, 
              type=:type, 
              contacts:=contacts 
              WHERE id_magasin=:id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":nom",$this->nom);
    $stmt->bindParam(":latitude", $this->latitude);
    $stmt->bindParam(":longitude", $this->longitude);
    $stmt->bindParam(":id_magasin", $this->id_magasin);
    $stmt->bindParam(":chef_magasin", $this->$chefMagasin);
    $stmt->bindParam(":type", $this->type);
    $stmt->bindParam(":contacts", $contactsString);
    $stmt->bindParam(":id", $this->id_magasin);

    if($stmt->execute()){
      return true;
    }else{
      return false;
    }
  }

  public function delete(){
    $query = "DELETE FROM ".$this->name_table." WHERE id_magasin = ?";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1,$this->id_magasin);
    if($stmt->execute()){
      return true;
    }else{
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

}

?>