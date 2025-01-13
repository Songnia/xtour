<?php

class Utilisateur{
  private $conn;
  private $name_table = "Utilisateur";


  public $id_utilisateur ;
  public $nom;
  public $prenom;
  public $nom_utilisateur;
  public $mot_de_passe;
  public $date_arrive_dans_entreprise;
  public $role;

  public function __construct($db){
    $this->conn = $db;
  }

  // Cree un utilisateur
  public function create(){
    try{
      $query = "INSERT INTO ". $this->name_table ." SET nom=:nom, prenom=:prenom, nom_utilisateur=:nom_utilisateur, mot_de_passe=:mot_de_passe, date_arrive_dans_entreprise=:date_arrive_dans_entreprise, role=:role";
      $stmt = $this->conn->prepare($query);

      // Hacher le mot de passe avant de le stocker
      //$hashed_password = password_hash($this->mot_de_passe, PASSWORD_DEFAULT);

      // Liaison avec les parametres
      $stmt->bindParam(":nom",$this->nom);
      $stmt->bindParam(":prenom",$this->prenom);
      $stmt->bindParam(":nom_utilisateur",$this->nom_utilisateur);
      $stmt->bindParam("mot_de_passe", $this->mot_de_passe);
      $stmt->bindParam(":date_arrive_dans_entreprise",$this->date_arrive_dans_entreprise);
      $stmt->bindParam(":role",$this->role);

      if ($stmt->execute()){
        return true;
      }else{
        return false;
      }
    }catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
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


  public function readComerciaux(){
    try{
      $query = "SELECT * FROM ".  $this->name_table ." WHERE role = :role ORDER BY id_utilisateur DESC";
      $stmt = $this->conn->prepare($query);
      $this->role = "Commercial";
      $stmt->bindParam(":role",$this->role);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
    }    

  }

  public function readComerciaux_code($nomUtilisateur){
    try{
      $query = "SELECT * FROM ".  $this->name_table ." WHERE nom_utilisateur = :nom_utilisateur";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":nom_utilisateur",$nomUtilisateur);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
    }  
  }

  public function attributCommerciaux($comName,$id_responsable,$id_com){
    try{
        $query = "INSERT INTO Relation_Hierarchique (id_commercial, id_responsable, nom_commercial) VALUES (:id_commercial, :id_responsable, :nom_commercial)"; 
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_commercial", $id_com);
        $stmt->bindParam(":id_responsable", $id_responsable);
        $stmt->bindParam(":nom_commercial", htmlspecialchars($comName));
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
  }


  public function getCommerciauxByResponsable($identifiantResponsable) {
    try {
        // Déterminer si l'identifiant est numérique ou alphanumérique (nom_utilisateur ou id_utilisateur)
        $field = is_numeric($identifiantResponsable) ? 'UR.id_utilisateur' : 'UR.nom_utilisateur';

        // Requête SQL avec jointure pour récupérer les commerciaux attribués au responsable
        $query = "
            SELECT U.nom, U.prenom, U.id_utilisateur, U.nom_utilisateur 
            FROM Utilisateur U
            JOIN Relation_Hierarchique R 
                ON U.id_utilisateur = R.id_commercial
            JOIN Utilisateur UR 
                ON UR.id_utilisateur = R.id_responsable
            WHERE $field = :identifiant;
        ";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identifiant', $identifiantResponsable, is_numeric($identifiantResponsable) ? PDO::PARAM_INT : PDO::PARAM_STR);
        $stmt->execute();

        // Récupération des résultats sous forme de tableau associatif
        $commerciaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retour du tableau (même vide si aucun commercial trouvé)
        return $commerciaux;

    } catch (Exception $e) {
        // Gestion de l'erreur
        error_log($e->getMessage());
        return ["error" => "Une erreur s'est produite : " . $e->getMessage()];
    }
}





  //Recuperer l ID du reponsable commercial dans la table Relation_Hierarchique
  /*public function getIdCom(){
    try {
        $query = "SELECT id_commercial, nom_commercial FROM Relation_Hierarchique";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);
                
        // Exécution de la requête
        $stmt->execute();
        
        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC); 
         
         if ($result) {
            //var_dump($result);
            return $result;  // Retourne l'ID commercial si trouvé
        }
    } catch (Exception $e) {
        // Gestion de l'erreur
        error_log($e->getMessage());  
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
}*/


  //recuper le nom du commercial a partir de son identifiant recuperer grace a getIdCom
  public function getNameCom($id_com){
    try{
      $query = "SELECT nom, prenom FROM ".  $this->name_table ." WHERE id_utilisateur = :id_utilisateur  ORDER BY id_utilisateur DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":id_utilisateur",$id_com, PDO::PARAM_INT);
      //$stmt->bindParam(":role",$role, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
      //$results =  $stmt->fetchAll(PDO::FETCH_ASSOC);
      /*var_dump($results);
      //echo "___________ <br>";

      $table_name = [];


      foreach($results as $result){
        $table_name[] = $this->readComerciaux_code($result["nom"]);
        echo "<pre>";
          var_dump($table_name);
        echo "</pre>";
        echo $table_name[0][0]["nom"]." ".$table_name[0][0]["prenom"];
        //echo "___________ <br>";
      }
      echo "<pre>";
      //print_r($table_name);
      echo "</pre>";
      return $table_name;*/
    }catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      error_log($e->getMessage());
      echo "Erreur capturée : " . $e->getMessage();
      return false;
    }       
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

  public function updatePassword($code){
    $query = "UPDATE ".$this->name_table." SET mot_de_passe=:mot_de_passe";
    $stmt = $this->conn->prepare($query);

    // Liaison avec les parametres
    $stmt->bindParam(":mot_de_passe",$code);

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

  public function login($nom, $prenom, $mot_de_passe) {
    // Préparer la requête SQL pour sélectionner l'utilisateur correspondant
    $query = "SELECT * FROM " . $this->name_table . " WHERE nom = :nom AND prenom = :prenom LIMIT 1";
    $stmt = $this->conn->prepare($query);

    // Lier les paramètres
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":prenom", $prenom);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Authentification réussie, initialiser les propriétés de l'objet
        $this->id_utilisateur = $user['id_utilisateur'];
        $this->nom = $user['nom'];
        $this->prenom = $user['prenom'];
        $this->date_arrive_dans_entreprise = $user['date_arrive_dans_entreprise'];
        $this->role = $user['role'];
        // Ne pas stocker le mot de passe en clair
        return true;
    } else {
        // Échec de l'authentification
        return false;
    }
}

public function getIDUser($newcode){
  try{
    $query = "SELECT id_utilisateur FROM Utilisateur WHERE mot_de_passe = :mot_de_passe";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":mot_de_passe", $newcode);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["id_utilisateur"];
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