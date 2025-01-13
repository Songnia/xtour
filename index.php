<?php 
// Insérer le header
    include_once("includes/header.php");
?>
<main class="main-connexion">
    <form class="form-connexion" action="includes/classes/user_method/login.php" method="POST">
        <p class="title-form-connexion">Connexion </p>
        <p class="message">connectez-vous. </p>
            <label>
                <input required="" placeholder="" name="user_name" type="text" class="input input_error">
                <span>Nom d'utilisateur</span>
            </label>

            <!--<label>
                <input required="" placeholder="" name="prenom" type="text" class="input">
                <span>Prenom</span>
            </label> -->
  
            
        <label>
            <input required="" name="pass" placeholder="" type="password" class="input input_error">
            <span>Password</span>
        </label>
        <label style="padding-left:10px;">
            <div id="error" class="error-message">
                <?php
                    $error = 0;
                    if (isset($_GET['parametre'])) {
                        $error = $_GET['parametre'];
                    }
                    echo $error;  
                ?>
            </div>
        </label>
        <button class="submit">Submit</button>
    </form>
</main>
<script>
    const error = document.getElementById("error");
    const inputError = document.querySelectorAll(".input_error");

    // Vérifie si le contenu de "error" est "0"
    if (error.textContent.trim() === "0") {
        error.style.display = "none";
    } else {
        inputError.forEach((element) => {
            element.style.border = "2px solid red";
            element.style.transition = 'all 0.2s ease-in';
        });
        error.textContent = "Informations incorrectes";
    }
</script>
<?php //include_once("../includes/footer.php"); ?>
