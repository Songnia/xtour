<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - Connexion perdue</title>
    <style>
        body {
            height: 100vh;
            font-family: Arial, sans-serif;
            text-align: center;
            background-color:rgb(217, 248, 215);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px gray;
            display: inline-block;
        }
        .btn {
            padding: 10px 20px;
            background-color:rgb(34, 190, 23);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Erreur : Connexion perdue</h2>
    <p>Votre session a expiré ou vous avez perdu la connexion.</p>
    <a class="btn" href="../index.php">Se reconnecter</a>
</div>

</body>
</html>
