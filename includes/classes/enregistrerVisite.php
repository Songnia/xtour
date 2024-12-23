
<?php
echo"<pre>";
var_dump($_POST);
var_dump($_FILES);
echo"</pre>";
// Connexion à la base de données
include_once("Database.php");
include_once("Magasin.php");
$database = new Database();
$db = $database->getConnection();
$magasinDB = new Magasin($db);

// Récupération des données du formulaire
$ville = $_POST['ville']; //ville
$magasin = $_POST['nom']; // Nom du magasin
$produit = $_POST['product']; // Nom du produit
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

echo"<pre>";
    var_dump($_POST);
echo"</pre>";

function readrapport($db) {
    try {
        $query = "
        SELECT 
            v.id_visite,
            v.tournee_id,
            v.magasin_id,
            v.ville,
            v.date_visite,
            v.feedback,
            v.feedback_value,
            v.feedback_description,
            sp.id_stock,
            sp.produit_id,
            sp.date_fabrication,
            sp.date_expiration,
            sp.etat AS stock_etat,
            sp.quantite_rayon,
            sp.quantite_stock,
            sp.qts_rayon,
            sp.qts_stock,
            sp.image_path,
            rv.id_reponse,
            rv.etiquette,
            rv.presence_promotrice,
            rv.existance_promotrice,
            rv.emplacement,
            rv.visibilite_produit,
            rv.prix_etiquette
        FROM 
            Visite v
        LEFT JOIN 
            stocks_produits sp ON v.id_visite = sp.visite_id
        LEFT JOIN 
            reponses_verification rv ON v.id_visite = rv.visite_id;
        ";

        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: []; // Retourne un tableau vide si aucune donnée n'est trouvée
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Erreur capturée : " . $e->getMessage();
        return false;
    }
}

//Recuperet l'ID du magasin
$magasin_id = $magasinDB->getIDMagasin($magasin);
$magasin_id = $magasin_id['id_magasin'];
// Recuperer l'image
    //Les verification sur l image
    //ON verifie toujour lextiension et le typeMyme
    try{
        $allowed = [
            "jpg" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "png" => "image/png"
        ];

        $filename = $_FILES["image"]["name"];
        $filetype = $_FILES["image"]["type"];
        $filesize = $_FILES["image"]["size"];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        //On verifie labscence de l extension dans les clesde $allowed et du typeMime
        if(!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)){
            //Ici soit le nom soit le type est incorrect
            die("format de fichier incorect");
        }

        //Ici le type est correct
        if($filesize > 1024*1024){
            die("Fichier trop volumineux");
        }
    
        //On genere un nom unique
        $newName = md5(uniqid());
        //On gere le chemin complet
        $newFileName =  __DIR__ ."/images/$newName.$extension";
        // Vérification et création du dossier si nécessaire
        $hhh = "/xtour/includes/classes/images/" . $newName . '.' . $extension;
        echo "L'image a été téléchargée avec succès : <a href='$hhh'>Voir l'image</a>";
        echo "<img src='$hhh' alt='Image téléchargée' style='max-width:300px; max-height:300px;'>";
    
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newFileName)) {
            die("L upload a echoué. Erreur probable : " . print_r(error_get_last(), true));
            
        }
    } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            error_log($e->getMessage());
            echo "Erreur capturée : " . $e->getMessage();
            return false;
        }

try {
    $db->beginTransaction();
    try{
        // Insertion des informations dans la table "visite"
        $query = "INSERT INTO Visite (ville, tournee_id, magasin_id, feedback_value, feedback_description  ) VALUES (:ville, :tournee_id, :magasin_id, :feedback_value, :feedback_description)";
        $tournee_id = rand(1, 3); //on fait un random en attendans de gerer les Tourneer
        $stmt = $db->prepare($query);
        $stmt->bindParam("ville",$ville);
        $stmt->bindParam("tournee_id",$tournee_id);
        $stmt->bindParam("magasin_id",$magasin_id);
        $stmt->bindParam("feedback_value",$feedback_value);
        $stmt->bindParam("feedback_description",$feedback_description);
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
        $query = "INSERT INTO stocks_produits (visite_id, produit_id, date_fabrication, date_expiration, etat, quantite_rayon, quantite_stock, qts_rayon, qts_stock, image_path) 
                                VALUES (:visite_id, :produit_id, :dateFab, :dateExp, :etat, :quantiteRayon, :quantiteStock, :qtsRayon, :qtsStock, :image_path)";
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
    //echo "Données enregistrées avec succès.";
} catch (Exception $e) {
    // Annulation de la transaction en cas d'erreur pour éviter des incohérences
    $db->rollBack();
    echo "Erreur : " . $e->getMessage(); // Affichage du message d'erreur
}
header("Location: ../../pages/visite.php");


?>
