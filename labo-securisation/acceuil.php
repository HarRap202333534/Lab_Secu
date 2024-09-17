<?php
session_start();
//verification de si on à un utilisateur de connecté.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
</head>
<body>
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Vous êtes connecté avec succès.</p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>