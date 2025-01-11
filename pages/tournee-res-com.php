<?php $titre = "Tournées"; 
    $namePage = "tournee-res-com.php";

session_start();
switch($_SESSION['role']) {/*'Admin', 'Commercial', 'responsable_commercia...	*/
        case 'Admin': 
        include_once("../includes/sidebar-mobile.php");
        include_once("../includes/sidebar.php");
        break;
        
        default:
        include_once("../includes/sidebar-com.php");
        include("../includes/sidebar-mobile-com.php");
}
$id_utilisateur = $_SESSION['id_utilisateur'];
// Insérer le header
include("../includes/header.php");

// Insérer la Sidebar commercial
include_once("../includes/classes/Tournee.php");
include_once("../includes/classes/Magasin.php");
include_once("../includes/classes/Database.php");

$database = new Database();
$db = $database->getConnection();

$tournee = new Tour($db);
$query = "SELECT * FROM Tournee  WHERE utilisateur_id = ".$id_utilisateur." ORDER BY date_enregistrement DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$tournees = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
    /*var_dump($tournees[0]);  // Affiche l'objet Tournee avec ses propriétés
    echo"-----------------------------<br>";
    var_dump($tournees);*/
echo "</pre>";

$tours = new Tour($db);
/*echo "<pre>";
var_dump($tours);  // Affiche l'objet Tour avec ses propriétés
echo "</pre>";*/

?>


<div class="main-content">
    <header>
        <div class="page-controls">
            <form id="tourneeForm">
                <div id="h3-inline"> <h3 id="maga-h3">Planifier une Tournée</h3> 
                    <div class="radio-inputs">
                    <label class="radio" onclick="showtournee_actuel()">
                        <input id="list" type="radio" name="radio" checked="">
                        <span class="name">Tournee Actuelle</span>
                    </label>
                    <label class="radio" onclick="showHistorique()">
                        <input id="detail" type="radio" name="radio" value="1">
                        <span class="name">Historique</span>
                    </label>
                    </div>
                </div>
            </form>
            <button id="addButton" class="btn-purple">Ajouter Tournée</button>
        </div>
    </header>

    
    <!--    Table Container valider-->

        <div class="table-container" id="tournee-actuel">
                    <h3 style="display:inline" >Tournée <?php echo $tournees[0]['code']; ?></h3>
                    <div class="toolbar">
                    <div class="heartool">
                    <div>
                        <button class="btn btn-green" onclick="openModalAddTour('<?php echo $tournees[0]['code']; ?>')">Ajouter un magasin</button>
                        <button class="btn btn-green" onclick="openModalSetStatutTournee('<?php echo $tournees[0]['code']; ?>')" >Valider</button>
                    </div>
                    <span>
                    <?php
                                $statut = $tournees[0]['statut'];
                                switch($statut){
                                    case 0: $html = "<span style='margin:5px; color:red;font-style:italic; border:1px solid red; padding:5px' >";
                                                    echo $html."En attente </span>";
                                                    break;
                                    case 1: $html = "<span style='margin:5px; color:green; border:1px solid green; padding:5px' >";
                                                    echo $html."Valider </span>";
                                                    break;
                                    case 2: $html = "<span style='margin:7px; color:green; font-weight:bold' >";
                                                    echo $html."Effectuer </span>";
                                                    break;
                                    default: 
                                            echo"En attente";
                                }                            
                            ?>
                    </span>
                        
                    </div>
                    </div>
                                <?php  //if($tournees===null){echo "Aucune tournee n a encore ete planifier";}?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom Magasin</th>
                                    <th>Date</th>
                                    <th>Jour</th>
                                    <th>Remarque</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $tours_list = $tours->read($tournees[0]['code']);                         
                                    foreach ($tours_list as $tour){  
                                    ?>
                                <tr>
                                
                                    <td><?php echo $tour['nom_magasin']; ?></td>
                                    <td><?php echo $tour['date']; ?></td>
                                    <td><?php echo $tour['jour']; ?></td>
                                    <td id="objectifs"><?php echo $tour['Objectif']; ?></td>
                                    <td>
                                        <!--<button class="btn btn-purple" onclick="sedTourneeInformation('<?php echo $tour['nom_magasin']; ?>' , '<?php echo $tournees[0]['ville']; ?>', '<?php echo $tournees[0]['code']; ?>')" >visiter</button> -->
                                        <!--<button class="addButton2 btn btn-green">Modifier</button> -->
                                        <button class=" btn btn-purple" onclick="openModalRemarque('<?php echo $tour['id_tour']; ?>', '<?php echo $tour['Objectif']; ?>')">Ajouter une Remarque</button>
                                    </td>
                                </tr>
                                <?php }?>
                                <!-- Repeat rows as needed -->
                            </tbody>
                        </table>
        </div>
    
        <?php foreach ($tournees as $tournee): ?>
                <div class="table-container histo">
                        <h3 style="display:inline" >Tournée <?php echo $tournee['code']; ?></h3>
                        <div class="toolbar">
                            <div class="heartool">
                                <div>
                                    <button class="btn btn-green" onclick="openModalAddTour('<?php echo $tournee['code']; ?>')">Ajouter un magasin</button>
                                    <button class=" btn btn-green" onclick="openModalSetStatutTournee('<?php echo $tournee['code']; ?>')">Valider</button>
                                </div>
                                <span>
                                <?php
                                    $statut = $tournee['statut'];
                                    switch($statut){
                                        case 0: $html = "<span style='margin:5px; color:red;font-style:italic; border:1px solid red; padding:5px' >";
                                        echo $html."En attente </span>";
                                        break;
                                        case 1: $html = "<span style='margin:5px; color:green; border:1px solid green; padding:5px' >";
                                                        echo $html."Valider </span>";
                                                        break;
                                        case 2: $html = "<span style='margin:7px; color:green; font-weight:bold' >";
                                                        echo $html."Effectuer </span>";
                                                        break;
                                        default: 
                                                echo"En attente";
                                    }                  
                            ?>
                                </span>
                            </div>
                        </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nom Magasin</th>
                                        <th>Date</th>
                                        <th>Jour</th>
                                        <th>Remarque</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    
                                    <?php
                                        $tours_list = $tours->read($tournee['code']);
                                        
                                        foreach ($tours_list as $tour){ 

                                    ?>
                                        <td><?php echo $tour['nom_magasin']; ?></td>
                                        <td><?php echo $tour['date']; ?></td>
                                        <td><?php echo $tour['jour']; ?></td>
                                        <td id="objectifs"><?php echo $tour['Objectif']; ?></td>
                                        <td>
                                            <!--<button class="btn btn-purple" onclick="sedTourneeInformation('<?php echo $tour['nom_magasin']; ?>' , '<?php echo $tournee['ville']; ?>' , '<?php echo $tournee['code']; ?>')" >visiter</button>
                                            <button class="addButton2 btn btn-green">Modifier</button>
                                            <button class="buttonValider btn delete-btn">Supprimer</button>-->
                                            <button class=" btn btn-purple" onclick="openModalRemarque('<?php echo $tour['id_tour']; ?>', '<?php echo $tour['Objectif']; ?>')">Ajouter une Remarque</button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <!-- Repeat rows as needed -->
                                </tbody>
                            </table>
                        </div>
                </div>
        <?php endforeach ?>
</div>





<!-- Pop-up Modal add visite -->

<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <h2>Ajouter une Tournee</h2>
        
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <form method="POST" action="../includes/classes/tournee_method/create_tournee.php" class="form-col">
            <div class="infoPMagasin">
                    <div>
                        <label for="Ville"></label>
                            <select name="ville" id="type">
                                <option value="">Ville</option>
                                <option value="Douala">Douala</option>
                                <option value="Yaounde">Yaounde</option>
                            <!-- Autres options ici -->
                            </select>
                    </div> 
                    <?php 
                        try{
                            $query = "SELECT nom FROM Magasin ORDER BY date_enregistrement DESC";
                            $stmt = $db->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            //var_dump($result);
                        } catch (Exception $e) {
                                // Annuler la transaction en cas d'erreur
                                $db->rollBack();
                                error_log($e->getMessage());
                                echo "Erreur capturée : " . $e->getMessage();
                                return false;
                        }                                    
                    
                    ?>
                    <div>
                        <select name="nom_magasin" id="nom_magasin">
                            <option value="">Nom du magasin</option>
                            <?php foreach($result as $res): ?>
                                <option value="<?php echo htmlspecialchars($res['nom']); ?>" <?php if ($nom == $res['nom']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($res['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>  

            </div>
            <div class="infoPMagasin">
                <div>
                    <select id="jours" name="jour">
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimache">Dimache</option>
                    <!-- Autres options ici -->
                    </select>
                </div>
                <div>
                    <input name="date" type="date">
                </div>
            </div>
            <div class="infoPMagasin" style="justify-content: center">
                    <select name="name_commercial" id="name_commercial" style="width:100%">
                        <option value="">Choisir le commercial</option>
                    </select>
            </div>
            <div class="infoPMagasin" style="justify-content: center">
                    <textarea name="remarque" id="remarque1" placeholder="Ajouter une remarque.." style="width:100%"></textarea>
            </div>
            <!-- Bouton Ajouter en bas -->
            <div class="infoPMagasin">
                <button type="submit" class="add-button">Ajouter</button>
            </div>        
        </form>

        <!-- Bouton Ajouter en bas -->
    </div>
</div> 

<!-- Pop-up Modal edit tournee -->
<div id="productModal2" class="modal">
    <div class="modal-content">
        <span class="close-button2" onclick="closeModal()">&times;</span>
        <h2 id="titletour">Ajouter un Magasin</h2>
        
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <form method="POST" action="../includes/classes/tournee_method/create_tour.php"  class="form-col">
            <input type="hidden" id="code_tournee" name="code_tournee" >
            <div>
                <select name="nom_magasin" id="nom_magasin">
                            <option value="">Nom du magasin</option>
                            <?php foreach($result as $res): ?>
                                <option value="<?php echo htmlspecialchars($res['nom']); ?>" <?php if ($nom == $res['nom']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($res['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                </select>
            </div>  
            
            <div>
                <label for="date">Date</label>
                <input name="date" type="date" required>
            </div>

            <div>
                <label for="jour">Jour</label>
                <select id="jours" name="jour" required>
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimache">Dimache</option>
                </select>
            </div>
            <div class="infoPMagasin" style="justify-content: center">
                    <textarea name="remarque" id="remarque1" placeholder="Ajouter une remarque.." style="width:100%"></textarea>
            </div>
            <div class="infoPMagasin">
                <button type="submit" class="add-button" tyle="width:100%">Ajouter</button>
            </div>
        </form>    

    </div>
</div> 

<!-- Confirm validation -->
<div class="modal" id="ModalStatut">
    <form method="POST" action="../includes/classes/tournee_method/setStatut.php">
        <input type="hidden" name="code_tournee2" id="code_tournee2">
        <div class="card ">
            <div class="image">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </div>
            <p class="cookieHeading" id="iiii">Vous validez la tournée</p>

            <div class="buttonContainer">
                <button type="submit" class="acceptButton">Allow</button>
                <button  class="declineButton">Decline</button>
            </div>
        </div>
    </form>
</div>

<div id="remarqueModal" class="modal" >
    <div class="modal-content">
        <span class="close-button2" onclick="closeModal()">&times;</span>
        <h2>Ajouter une remarque</h2>
        <form class="form-col" method="POST" action="../includes/classes/tournee_method/update_tour.php">
            <input type="hidden" name="id_tour" id="id_tour">
            <textarea name="remarque" id="remarque"></textarea>
            <button type="submit" class="btn btn-green" style="margin:10px 0; width:100%">Enregistrer</button>
        </form>
    </div>
</div> 

<?php include("../includes/footer.php"); ?>
