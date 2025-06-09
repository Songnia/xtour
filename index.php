<link rel="icon" type="image/png" sizes="32x32" href="assets/Visimags-carre1.png">
<?php 
// Insérer le header
    $titre ="Acceuil";
    include_once("includes/header.php");
?>
<style>
    body {
        display: flex;
        flex-direction: column;
        background-color: #f0f0f0; /* Couleur de fond du body */
        margin: 0;
        font-family: Arial, sans-serif;
        }
    #child-main{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 2%;
        font-style : italic;
        font-weight: 10;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    #child-main img{
        width: 250px;
        height: 250px;
    }
    #passW{
        position: relative;
    }
    #eye{
        cursor: pointer;
        position: absolute;
        right: 10px;
        top:8px;
    }
    @media (max-width: 576px) {
        #child-main img{
            width: 100px;
            height: 100px;
        }
    }
</style>
<main class="main-connexion">
    <div id="child-main" >
        <img src="assets/logoNgon.png" alt="">
        <span>Logiciel de gestion de tournées</span>
    </div>
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
            <input required="" name="pass" placeholder="" type="password" class="input input_error" id="passW">
            <span>Password</span>
            <span id="eye">
                <svg width="50" height="30" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <!-- Contour de l'œil -->
                    <path d="M50 20C30 20 10 35 10 50C10 65 30 80 50 80C70 80 90 65 90 50C90 35 70 20 50 20Z" fill="none" stroke="black" stroke-width="3"/>
                    
                    <!-- Iris -->
                    <circle cx="50" cy="50" r="15" fill="black"/>
                    
                    <!-- Pupille -->
                    <circle cx="50" cy="50" r="7" fill="black"/>
                </svg>
            </span>
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
    const eye = document.getElementById("eye");
    const passW = document.getElementById("passW");

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

    eye.addEventListener('click', function(){
        // Basculer du type password au type text
        const type = passW.getAttribute('type') === 'password' ? 'text' : 'password';
        passW.setAttribute('type',type);
    })

</script>
<?php include_once("includes/footer.php"); ?>
