<?php

  class Produit{
    private $conn;
    private $table_name = "Produit";

    //	id_produit	nom_commercial	nom_descriptif	prix	poids	date_enregistrement	
    public $id_produit;
    public $nom_commercial;
    public $nom_descriptif;
    public $prix;
    public $poids;
    public function __construct($db){
      $this->conn = $db;
    }

    //cree un utilisateur
    public function create(){
      $query = "INSERT INTO " . $this->table_name. " SET nom_commercial=:nom_commercial, nom_descriptif=:nom_descriptif, prix=:prix, poids=:poids ";
      $stmt = $this->conn->prepare($query);

      // Liaison des parametres
      $stmt->bindParam(":nom_commercial", $this->nom_commercial);
      $stmt->bindParam(":nom_descriptif", $this->nom_descriptif);
      $stmt->bindParam(":prix", $this->prix);
      $stmt->bindParam(":poids", $this->poids);

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    // Lire les produits
    public function read(){
      $query = "SELECT * FROM " . $this->table_name. " ORDER BY id_produit DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre a jour un produit
    public function update(){
      $query = "UPDATE ".$this->table_name . " SET nom_commercial=:nom_commercial, nom_descriptif=:nom_descriptif, prix=:prix, poids=:poids WHERE id_produit = :id";
      $stmt = $this->conn->prepare($query);

      // Liaison des parametres
      $stmt->bindParam(":nom_commercial", $this->nom_commercial);
      $stmt->bindParam(":nom_descriptif", $this->nom_descriptif);
      $stmt->bindParam(":prix", $this->prix);
      $stmt->bindParam(":poids", $this->poids);
      $stmt->bindParam(":id", $this->id_produit);
      

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    // Supprimer un produit

    public function delete(){
      $query = "DELETE FROM ". $this->table_name . " WHERE id_produit = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id_produit);

      if($stmt->execute()){
        return true;
      }
      return false;
    }
    
  }  

?>