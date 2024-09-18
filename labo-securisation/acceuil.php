<?php
session_start();
function getUserRole($userId) {
    include "pdo.php";

    $sql = "SELECT role_id FROM users WHERE users.username = ?";
    $resultat = $con->prepare($sql);

    if(isset($_SESSION['username'])) 
    {
        $resultat->execute([$_SESSION['username']]);
    }

    $con = null;
    $id = $resultat->fetch();
    return $id[0];
}
function getEtatBombe() {
    include "pdo.php";

    $sql = "SELECT lance, DATE_FORMAT(ADDTIME('00:00:00', SEC_TO_TIME(TIMESTAMPDIFF(SECOND, temps, NOW()))), '%H heures, %i minutes, %s secondes') AS temps_ecoule FROM bombe WHERE noBombe = ?";
    $resultat = $con->prepare($sql);

    $resultat->execute([1]);

    $con = null;
    $etat = $resultat->fetch();

    return $etat;
}

//verification de si on à un utilisateur de connecté.
if (!isset($_SESSION['username'])) {
    header("Location: connexion.php");
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
    <?php
        if(isset($_SESSION['username'])) {
            $etat = getEtatBombe();
            if(getUserRole($_SESSION['username']) == 1) {
                if($etat['lance'] == 0){
                    echo '<form method="post" action="buttonBomb_action.php"><button type="submit">Lancer les bombes</button></form>';
                }
                else{
                    echo '<form method="post" action="buttonReset_action.php"><button type="submit">Réinitialiser</button></form>';
                }
            }
            else if(getUserRole($_SESSION['username'] == 2)) {
                if($etat['lance'] == 1){
                    echo "<p>Les bombes ont été lancées depuis " . $etat['temps_ecoule'] . ".</p>";
                }
                else{
                    echo "<p>Les bombes n'ont pas été lancées.</p>";
                }
            }
        }
    ?>
    <a href="logout.php">Déconnexion</a>
</body>
</html>