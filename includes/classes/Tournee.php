<?php

class Tour {
    private $conn;
    private $table_name = "Tour";

    public $id_tour;
    public $id_tournee;
    public $ville;
    public $nom_magasin;
    public $date;
    public $code;
    public $jour;
    public $objectif=" ";
    public $statut=0;

    public $id_visite;
    public $commentaire;
    public $heure_visite;
    public $statut_visite;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fonctionnalités liées aux tournées
    // Créer une tournée
    public function createTournee($id_user) {
        try {
            $this->conn->beginTransaction(); // Démarre une transaction

            $query = "INSERT INTO Tournee SET 
                    ville =:ville,
                    utilisateur_id = :utilisateur_id,
                    code = :code";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":utilisateur_id", $id_user);
            $stmt->bindParam(":code", $this->code);
            $stmt->bindParam(":ville", $this->ville);

            $stmt->execute();
            $this->conn->commit(); // Valide la transaction

            $last_id = $this->conn->lastInsertId();
            echo "Dernier ID inséré : " . $last_id;
            return true;

        } catch (Exception $e) {
          // Annuler la transaction en cas d'erreur
          $this->conn->rollBack();
          error_log($e->getMessage());
          echo "Erreur capturée : " . $e->getMessage();
          return false;
      }
    }



    // Supprimer une tournée
    public function deleteTournee() {
        try {
            $query = "DELETE FROM Tournee WHERE id_tournee = :id_tournee";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id_tournee", $this->id_tournee);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Modifier le statut d'une tournée
    public function updateTourneeStatus() {
        try {
            $query = "UPDATE Tournee SET statut = :statut WHERE code = :code";
    
            $stmt = $this->conn->prepare($query);
    
            // Mise à jour explicite du statut (1 ici pour actif)
            $statut = 1;
            $stmt->bindParam(":statut", $statut, PDO::PARAM_INT);
            $stmt->bindParam(":code", $this->code, PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Échec de la mise à jour du statut de la tournée.");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }
    

    //Mettre a jour le code.
    public function updateTourneecode($newcode) {
        try {
            $query = "UPDATE Tournee SET code = :newcode WHERE code = :code";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":code", $this->code);
            $stmt->bindParam(":newcode", $newcode);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getIDTournee($newcode){
        try{
          $query = "SELECT id_tournee FROM Tournee WHERE code = :code";
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(":code", $newcode);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result["id_tournee"];
        } catch (Exception $e) {
          // Annuler la transaction en cas d'erreur
          error_log($e->getMessage());
          echo "Erreur capturée : " . $e->getMessage();
          return false;
      }      
      }

    // Valider une tournée
    /*public function validateTournee() {
        try {
            $query = "UPDATE Tournee SET statut = 'Validée' WHERE id_tournee = :id_tournee";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id_tournee", $this->id_tournee);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }*/

    // Fonctionnalités liées aux tours
    // Créer un tour
    public function create($code) {
        try {
            $this->conn->beginTransaction(); // Démarre une transaction
            $query = "INSERT INTO " . $this->table_name . " SET 
                      code_tournee = :code_tournee,
                      nom_magasin = :nom_magasin,
                      date = :date,
                      jour = :jour,
                      statut = :statut,
                      objectif =:objectif";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":code_tournee", $this->code);
            $stmt->bindParam(":nom_magasin", $this->nom_magasin);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":jour", $this->jour);
            $stmt->bindParam(":statut", $this->statut);
            $stmt->bindParam(":objectif", $this->objectif);

            $stmt->execute();
            $this->conn->commit(); // Valide la transaction
            return true;
        } catch (Exception $e) {
          // Annuler la transaction en cas d'erreur
          $this->conn->rollBack();
          error_log($e->getMessage());
          echo "Erreur capturée : " . $e->getMessage();
          return false;
      }
    }

    public function read($codeTour){
        try{
            $query = "SELECT * FROM " . $this->table_name . " WHERE code_tournee = :code ORDER BY date_enregistrement DESC";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":code", $codeTour);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            return false;
        }

      }

    // Supprimer un tour
    public function delete() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_tour = :id_tour";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id_tour", $this->id_tour);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Modifier le statut d'un tour
    /*public function updateStatus() {
        try {
            $query = "UPDATE " . $this->table_name . " SET statut = :statut WHERE code = :code";
            $stmt = $this->conn->prepare($query);
            $this->statut = 1;
            $stmt->bindParam(":statut",$this->statut);
            $stmt->bindParam(":code", $this->code);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }*/

    public function updateObjectif() {
        try {
            $query = "UPDATE " . $this->table_name . " SET objectif = :objectif WHERE id_tour = :id_tour";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":objectif", $this->objectif);
            $stmt->bindParam(":id_tour", $this->id_tour);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Fonctionnalités liées aux visites

}

?>
