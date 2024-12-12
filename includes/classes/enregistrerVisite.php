
<?php
// Connexion à la base de données
include_once("Database.php");
include_once("Magasin.php");
$database = new Database();
$db = $database->getConnection();
$magasinDB = new Magasin($db);

// Récupération des données du formulaire
$magasin = $_POST['nom']; // Nom du magasin
$etiquette = $_POST['etiquette']; // Vérification de l'étiquette
$hotes = $_POST['hotes']; // Hôtes responsables
$emplacement = $_POST['emplacement']; // Emplacement du produit
$feedback = $_POST['feedback']; // Feedback général sur la visite
$produit = $_POST['product']; // Nom du produit
$dateFab = $_POST['dateFab']; // Date de fabrication du produit
$dateExp = $_POST['dateExp']; // Date d'expiration du produit
$etat = $_POST['etat']; // État du produit
$quantiteRayon = isset($_POST['quantiteRayon']) ? intval($_POST['quantiteRayon']) : null ; // Quantité en rayon
$quantiteStock = isset($_POST['quantiteStock']) ? intval($_POST['quantiteStock']) : null; // Quantité en stock
$qtsRayon = isset($_POST['quantiteRayonQTS']) ? "QTS" : null; // Validation QTS pour le rayon
$qtsStock = isset($_POST['quantiteStockQTS']) ? "QTS" : null; // Validation QTS pour le stock

echo"<pre>";
    var_dump($_POST);
echo"</pre>";
//Recuperet l'ID du magasin
$magasin_id = $magasinDB->getIDMagasin($magasin);
$magasin_id = $magasin_id['id_magasin'];



// Gestion de l'image
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
            die("Seuls les fichiers JPEG, PNG et GIF sont autorisés.");
        }

        if ($_FILES['image']['size'] > $maxSize) {
            die("Le fichier est trop volumineux. Taille maximale : 2 Mo.");
        }

        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            echo "L'image a été téléchargée avec succès : <a href='$imagePath'>Voir l'image</a>";
            echo "<img src='$imagePath' alt='Image téléchargée' style='max-width:300px; max-height:300px;'>";
        } else {
            echo "Erreur lors de l'enregistrement de l'image.";
        }
    } else {
        echo "Aucune image téléchargée ou une erreur est survenue.";
    }

try {
    $db->beginTransaction();
    try{
        // Insertion des informations dans la table "visite"
        $query = "INSERT INTO Visite (tournee_id, magasin_id, feedback) VALUES ( :tournee_id,:magasin_id,:feedback)";
        $tournee_id = rand(1, 3);
        $stmt = $db->prepare($query);
        $stmt->bindParam("tournee_id",$tournee_id);
        $stmt->bindParam("magasin_id",$magasin_id);
        $stmt->bindParam("feedback",$feedback);
        $stmt->execute();
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
    $query = "SELECT id_visite FROM Visite WHERE magasin_id = :magasin_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":magasin_id", $magasin_id);
    $stmt->execute();
    $visite_id = $stmt->fetch(PDO::FETCH_ASSOC);
    $visite_id = $visite_id['id_visite'];


    // Insertion des réponses de vérification dans la table "reponse"
    try{
        $query = "INSERT INTO stocks_produits (visite_id, produit_id, date_fabrication, date_expiration, etat, quantite_rayon, quantite_stock, qts_rayon, qts_stock) 
                                VALUES (:visite_id, :produit_id, :dateFab, :dateExp, :etat, :quantiteRayon, :quantiteStock, :qtsRayon, :qtsStock)";
        $produit_id = rand(23, 25);
        $stmt = $db->prepare($query);
        $stmt->bindParam("visite_id",$visite_id);
        $stmt->bindParam("produit_id",$produit_id);
        $stmt->bindParam("dateFab",$dateFab);
        $stmt->bindParam("dateExp",$dateExp);
        $stmt->bindParam("etat",$etat);
        $stmt->bindParam("quantiteRayon",$quantiteRayon);
        $stmt->bindParam("quantiteStock",$quantiteStock);
        $stmt->bindParam("qtsRayon",$qtsRayon);
        $stmt->bindParam("qtsStock",$qtsStock);
        $stmt->execute();

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
    
    // Insertion des informations sur les stocks et produits dans la table "stock"
    try{
        $query = "INSERT INTO reponses_verification (visite_id,etiquette, hotes, emplacement) 
                            VALUES (:visite_id, :etiquette, :hotes, :emplacement)";
        $stmt = $db->prepare($query);
        $stmt->bindParam("visite_id",$visite_id);
        $stmt->bindParam("etiquette",$etiquette);
        $stmt->bindParam("hotes",$hotes);
        $stmt->bindParam("emplacement",$emplacement);
        $stmt->execute();
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }

    // Validation de la transaction si toutes les étapes réussissent
    $db->commit();
    //echo "Données enregistrées avec succès.";
} catch (Exception $e) {
    // Annulation de la transaction en cas d'erreur pour éviter des incohérences
    $db->rollBack();
    echo "Erreur : " . $e->getMessage(); // Affichage du message d'erreur
}
?>
