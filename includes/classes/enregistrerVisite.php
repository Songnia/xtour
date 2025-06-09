<?php
echo"<pre>";
var_dump($_POST);
//var_dump($_FILES);
echo"</pre>";

// Connexion à la base de données
include_once("Database.php");
include_once("Magasin.php");
include_once("Produit.php");
$database = new Database();
$db = $database->getConnection();
$magasinDB = new Magasin($db);
$produit = new Produit($db);
$quik_tour = $_POST['type'];
// Récupération des données du formulaire
if ($quik_tour == 0) {
    // Masquer les champs pour la tournée rapide
    $code_tournee = $_POST['codeTournee'];
    $ville = $_POST['ville']; // ville
    $magasin = $_POST['nom']; // Nom du magasin
    $produit_id = $_POST['product']; // ID du produit directement depuis le formulaire
    $quantiteRayon = isset($_POST['quantiteRayon']) ? intval($_POST['quantiteRayon']) : null ; // Quantité en rayon
    $qtsRayon = isset($_POST['quantiteRayonQTS']) ? "QTS" : null; // Validation QTS pour le rayon
    $statue = 1;
    //Recuperet l'ID du magasin
    $magasin_id = $magasinDB->getIDMagasin($magasin);
    $magasin_id = $magasin_id['id_magasin'];
} else {
    $code_tournee = $_POST['codeTournee'];
    $ville = $_POST['ville']; //ville
    $magasin = $_POST['nom']; // Nom du magasin
    $produit_id = $_POST['product']; // ID du produit directement depuis le formulaire
    $visibiliter = $_POST['visibiliter'];
    $etiquette = $_POST['etiquette']; // Vérification de l'étiquette
    $prix = $_POST['prix'];
    $etat = $_POST['etat']; // État du produit
    $dateFab = $_POST['dateFab']; // Date de fabrication du produit
    $dateExp = $_POST['dateExp']; // Date d'expiration du produit
    $quantiteRayon = isset($_POST['quantiteRayon']) ? intval($_POST['quantiteRayon']) : null ; // Quantité en rayon
    $quantiteStock = isset($_POST['quantiteStock']) ? intval($_POST['quantiteStock']) : null; // Quantité en stock
    $qtsRayon = isset($_POST['quantiteRayonQTS']) ? "QTS" : null; // Validation QTS pour le rayon
    $qtsStock = $_POST['quantiteStockQTS']; // Validation QTS pour le stock
    $presence_promotrice = $_POST['presence_promotrice']; // Hôtes responsables
    $existance_promotrice = $_POST['existance_promotrice'];
    $feedback_value = $_POST['feedback_value'];
    $emplacement = $_POST['emplacement']; // Emplacement du produit
    $feedback_description = $_POST['description']; // Feedback général sur la visite
    $statue = 1;
    //Recuperet l'ID du magasin
    $magasin_id = $magasinDB->getIDMagasin($magasin);
    $magasin_id = $magasin_id['id_magasin'];
    // Recuperer l'image
        //Les verification sur l image
        //ON verifie toujour lextiension et le typeMyme
    if(isset($_FILES["image"]) && !empty($_FILES["image"]["name"])){
        try{
            $allowed = [
                "jpg" => "image/jpg",
                "jpeg" => "image/jpeg",
                "png" => "image/png",
            ];
    
            $filename = $_FILES["image"]["name"];
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];
    
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            //On vérifie la présence de l'extension dans les clés de $allowed et du typeMime
            if(!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)){
                //Ici soit le nom soit le type est incorrect
                throw new Exception("Format de fichier incorrect");
            }
    
            //Ici le type est correct
            if($filesize > 30*1024*1024){
                throw new Exception("Fichier trop volumineux");
            }
            
            //On génère un nom unique
            $newName = md5(uniqid());
            
            // Vérification et création du dossier si nécessaire
            $uploadDir = __DIR__ . "/images/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            //On gère le chemin complet
            $newFileName = $uploadDir . $newName . "." . $extension;
            $relativePath = "/xtour/includes/classes/images/" . $newName . "." . $extension;
            
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newFileName)) {
                throw new Exception("L'upload a échoué. Erreur probable : " . print_r(error_get_last(), true));
            }
            
            $hhh = $relativePath; // Garde la variable pour compatibilité avec le reste du code
            
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            exit(); // Mieux que die() car permet l'exécution des destructeurs
        }
    }
}
// Récupération des données du formulaire


try {
    $db->beginTransaction();
    try{
        // Insertion des informations dans la table "visite"
        $query = "INSERT INTO Visite (ville, codeTournee, magasin_id, feedback_value, feedback_description,statue  ) VALUES (:ville, :codeTournee, :magasin_id, :feedback_value, :feedback_description, :statue)";
        $stmt = $db->prepare($query);
        $stmt->bindParam("ville",$ville);
        $stmt->bindParam("codeTournee",$code_tournee);
        $stmt->bindParam("magasin_id",$magasin_id);
        $stmt->bindParam("feedback_value",$feedback_value);
        $stmt->bindParam("feedback_description",$feedback_description);
        $stmt->bindParam("statue", $statue);
        $stmt->execute();
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
   $query = "SELECT id_visite FROM Visite WHERE magasin_id = :magasin_id ORDER BY id_visite DESC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":magasin_id", $magasin_id);
    $stmt->execute();
    $visite_id = $stmt->fetch(PDO::FETCH_ASSOC);
    $visite_id = $visite_id['id_visite'];
    var_dump($visite_id);
    // Insertion des réponses de vérification dans la table "reponse"
    try{
        $query = "INSERT INTO stocks_produits (visite_id, produit_id, date_fabrication, date_expiration, etat, quantite_rayon, quantite_stock, qts_rayon, qts_stock, image_path) 
                                VALUES (:visite_id, :produit_id, :dateFab, :dateExp, :etat, :quantiteRayon, :quantiteStock, :qtsRayon, :qtsStock, :image_path)";
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
        $stmt->bindParam("image_path",$hhh);
        $stmt->execute();

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
    // Insertion des informations sur les stocks et produits dans la table "stock"
    try{
        $query = "INSERT INTO reponses_verification (visite_id,etiquette, existance_promotrice, presence_promotrice, emplacement, visibilite_produit, prix_etiquette) 
                            VALUES (:visite_id, :etiquette, :existance_promotrice, :presence_promotrice, :emplacement, :visibilite_produit, :prix_etiquette)";
        $stmt = $db->prepare($query);
        $stmt->bindParam("visite_id",$visite_id);
        $stmt->bindParam("etiquette",$etiquette);
        $stmt->bindParam("existance_promotrice",$existance_promotrice);
        $stmt->bindParam("presence_promotrice",$presence_promotrice);
        $stmt->bindParam("emplacement",$emplacement);
        $stmt->bindParam("visibilite_produit",$visibiliter);
        $stmt->bindParam("prix_etiquette",$prix);
        $stmt->execute();
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
    // Validation de la transaction si toutes les étapes réussissent
    $db->commit();
} catch (Exception $e) {
    // Annulation de la transaction en cas d'erreur pour éviter des incohérences
    $db->rollBack();
    echo "Erreur : " . $e->getMessage(); // Affichage du message d'erreur
}
echo $code_tournee ." ".$magasin ." ".$ville;
header("Location: ../../pages/visite.php?codeTournee=" . urlencode($code_tournee) . "&nomMagasin=" . urlencode($magasin) . "&villeMagasin=" . urlencode($ville). "&typeTournee=" . urlencode($quik_tour)); 
exit();

?>
