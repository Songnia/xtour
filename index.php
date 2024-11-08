<?php 

// Insérer le header
include_once("../includes/header.php");
?>
<main class="main-connexion">
    <form class="form-connexion">
        <p class="title-form-connexion">Connexion </p>
        <p class="message">Login now and get full access to our app. </p>
            <div class="flex">
            <label>
                <input required="" placeholder="" type="text" class="input">
                <span>Firstname</span>
            </label>

            <label>
                <input required="" placeholder="" type="text" class="input">
                <span>Lastname</span>
            </label>
        </div>  
                
        <label>
            <input required="" placeholder="" type="email" class="input">
            <span>Email</span>
        </label> 
            
        <label>
            <input required="" placeholder="" type="password" class="input">
            <span>Password</span>
        </label>
        <a href="dashboard.php"><button class="submit">Submit</button></a>
    </form>
</main>

<?php include_once("../includes/footer.php"); ?>
