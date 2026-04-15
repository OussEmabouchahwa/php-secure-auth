<?php
// On vérifie si le bouton a été cliqué
$message = "";

if (isset($_POST['valider'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $validate_password = $_POST['confirm_password'];

    if (empty($nom)) $message .= "<li>Le nom est obligatoire</li>";
    if (empty($prenom)) $message .= "<li>Le prénom est obligatoire</li>";
    if (empty($login)) $message .= "<li>Le login est obligatoire</li>";
    if (empty($password)) $message .= "<li>Le mot de passe est obligatoire</li>";
    if ($password != $validate_password) $message .= "<li>Les mots de passe ne correspondent pas</li>";

    if (empty($message)){
        include("connexion.php");

        $req = $conn->prepare("SELECT * FROM users WHERE login = ?");
        $req->execute([$login]);
        $tab = $req->fetchAll();

        if (count($tab) > 0){
            $message = "<li>Ce login existe déjà</li>";
        } else {
            $req = $conn->prepare("INSERT INTO users (nom, prenom, login, pass, date) VALUES (?, ?, ?, ?, NOW())");
            $req->execute([$nom, $prenom, $login, password_hash($password, PASSWORD_DEFAULT)]);
            header("Location: login.php");
            exit();
        }
    }
}
?>
<html>
    <head>
        <title>Inscription</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
<header>Inscription 
    <a href="login.php">Déjà inscrit</a>
</header>
<?php if (!empty($message)) { ?>
    <div id='message'><ul><?php echo $message; ?></ul></div>
<?php } ?>
<form method="post" action="inscription.php">
    <label>Nom:</label>
    <input type="text" name="nom" required>

    <label>Prénom:</label>
    <input type="text" name="prenom" required>

    <label>Login:</label>
    <input type="text" name="login" required>

    <label>Mot de passe:</label>
    <input type="password" name="password" required>

    <label>Confirmer mot de passe:</label>
    <input type="password" name="confirm_password" required>
    <input type="submit" name="valider" value="S'inscrire">
</form>
</body>
</html>

