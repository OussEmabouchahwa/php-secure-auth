<?php
session_start();

// Vérifie si l'utilisateur est bien authentifié par le login
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] !== "oui"){
    header("Location: login.php");
    exit(); // Très important pour stopper l'exécution du reste de la page
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Espace Privé</title>
        <link rel="stylesheet" href="style.css" type="text/css" >
    </head>
    <body>
        <header> Espace privé 
            <a href="deconnexion.php">Se déconnecter</a>
        </header>
        
        <h1>
            <?php echo (date("H") < 18) ? "Bonjour" : "Bonsoir"; ?>, 
            <span>
                <?= $_SESSION["nomPrenom"] ?>
            </span>
        </h1>
        
        <p>Bienvenue dans votre espace sécurisé.</p>
    </body>
</html>