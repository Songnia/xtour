<?php

class Utilisateur{
  private $conn;
  private $name_table = "Utilisateur";


  public $id_utilisateur ;
  public $nom;
  public $prenom;
  public $date_arrive_dans_entreprise;
  public $role;

  public function __construct($db){
    $this->conn = $db;
  }

  // Cree un utilisateur
  public function create(){
    $query = "INSERT INTO ". $this->name_table ." SET nom=:nom, prenom=:prenom, date_arrive_dans_entreprise=:date_arrive_dans_entreprise, role=:role";
    $stmt = $this->conn->prepare($query);


    // Liaison avec les parametres
    $stmt->bindParam(":nom",$this->nom);
    $stmt->bindParam(":prenom",$this->prenom);
    $stmt->bindParam(":date_arrive_dans_entreprise",$this->date_arrive_dans_entreprise);
    $stmt->bindParam(":role",$this->role);

    if ($stmt->execute()){
      return true;
    }else{
      return false;
    }
  }

  // Lire les Utilisateurs
  public function read(){
    //❌❌❌❌❌❌❌❌❌ La jointure pour lire lesmagasin associer a chaque commerciaux ❌❌❌
    $query = "SELECT * FROM ".  $this->name_table ." ORDER BY id_utilisateur DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Mise a jour les utilisateurs
  public function update(){
    $query = "UPDATE ".$this->name_table." SET nom=:nom, prenom=:prenom, date_arrive_dans_entreprise=:date_arrive_dans_entreprise, role=:role WHERE id_utilisateur=:id";
    $stmt = $this->conn->prepare($query);

    // Liaison avec les parametres
    $stmt->bindParam(":nom",$this->nom);
    $stmt->bindParam(":prenom",$this->prenom);
    $stmt->bindParam(":date_arrive_dans_entreprise",$this->date_arrive_dans_entreprise);
    $stmt->bindParam(":role",$this->role);
    $stmt->bindParam(":id",$this->id_utilisateur);

    if($stmt->execute()){
      return true;
    }else{
      return false;
    }
  }

  public function delete(){
    try{
      $query = "DELETE FROM ". $this->name_table ." WHERE   id_utilisateur= ? ";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id_utilisateur);

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


  /*public function setRole($role) {
    $query = "UPDATE users SET role = :role WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    // Vérifier si le rôle fourni est valide
    $validRoles = ['Admin', 'Commercial', 'Responsable_commercial', 'Autre'];
    if (!in_array($role, $validRoles)) {
        throw new Exception("Rôle invalide : " . $role);
    }

    // Liaison des paramètres
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $this->id_utilisateur);

    return $stmt->execute();
}*/
  /**$user = new User($db);
  $user->id = 1; // ID de l'utilisateur à mettre à jour
  try {
      $user->setRole('Admin');
      echo "Rôle mis à jour avec succès.";
  } catch (Exception $e) {
      echo "Erreur : " . $e->getMessage();
  }
  * 
  */

  /*public function getUsersByRole($role) {
    $query = "SELECT * FROM users WHERE role = :role";
    $stmt = $this->conn->prepare($query);

    // Vérifier si le rôle est valide
    $validRoles = ['Admin', 'Commercial', 'Responsable_commercial', 'Autre'];
    if (!in_array($role, $validRoles)) {
        throw new Exception("Rôle invalide : " . $role);
    }

    $stmt->bindParam(':role', $role);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/
  /**$users = $user->getUsersByRole('Commercial');
  foreach ($users as $user) {
      echo $user['nom'] . " - " . $user['email'] . "\n";
  }
  */

}



?>