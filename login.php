<?php
session_start();
@$login = $_POST["login"];
@$password = $_POST["password"];
@$valider = $_POST["valider"];
$message = "";

if (isset($valider)) {
    include("connexion.php"); 
    
    $res = $conn->prepare("SELECT * FROM users WHERE login=?");
    $res->setFetchMode(PDO::FETCH_ASSOC);
    $res->execute(array($login));
    $tab = $res->fetchAll();
    
    if (count($tab) == 0) {
        $message = "<li>Mauvais login ou mot de passe!</li>";
    } else {
        $user = $tab[0]; 
        
        if (password_verify($password, $user['pass'])) {
            $_SESSION["autoriser"] = "oui"; 
            $_SESSION["nomPrenom"] = strtoupper(($user["nom"] . " " . $user["prenom"]));
            header("location:session.php");
            exit(); 
        } else {
            $message = "<li>Mauvais login ou mot de passe!</li>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />
</head>
<body>
    <header>
        Authentification
        <a href="inscription.php">S'inscrire</a>
    </header>

    <form method="POST" name="fo" action="">
        <div class="label">Login</div>
        <input type="text" name="login" placeholder="Login" value="<?php echo htmlspecialchars(@$login, ENT_QUOTES); ?>" required>

        <div class="label">Password</div>
        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" name="valider" value="S'authentifier" />

        <?php if (!empty($message)) { ?>
            <div id="message">
                <ul><?php echo $message; ?></ul>
            </div>
        <?php } ?>
    </form>
</body>
</html>