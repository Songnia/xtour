<?php 
// Insérer le header
    include_once("includes/header.php");
?>
<main class="main-connexion">
    <form class="form-connexion" action="includes/classes/user_method/login.php" method="POST">
        <p class="title-form-connexion">Connexion </p>
        <p class="message">connectez-vous. </p>
            <div class="flex">
            <label>
                <input required="" placeholder="" name="user_name" type="text" class="input">
                <span>Nom d'utilisateur</span>
            </label>

            <!--<label>
                <input required="" placeholder="" name="prenom" type="text" class="input">
                <span>Prenom</span>
            </label> -->
        </div>  
            
        <label>
            <input required="" name="pass" placeholder="" type="password" class="input">
            <span>Password</span>
        </label>
        <button class="submit">Submit</button>
    </form>
</main>

<?php //include_once("../includes/footer.php"); ?>
