<?php
session_start();

function addAttempt($user, $con){
    $sql = "UPDATE user_attempt SET attempts = ((SELECT attempts FROM user_attempt WHERE user_id = ?) + 1) WHERE user_id = ?";
    $result = $con->prepare($sql);
    $result->execute([$user, $user]);
    $result->closeCursor();
    if(getAttempt($user, $con)[0] == 5){
        $sql = "UPDATE user_attempt SET blocked = 1, last_attempt = NOW() WHERE user_id = ?";
        $result = $con->prepare($sql);
        $result->execute([$user]);
        $result->closeCursor();
    }
}

function getAttempt($user, $con){
    $sql = "SELECT attempts FROM user_attempt WHERE user_id = ?";
    $result = $con->prepare($sql);

    $result->execute([$user]);

    $attempts = $result->fetch();

    return $attempts;
}
function getTempsBloqueRestant($user, $con){
    $sql = "SELECT TIMESTAMPDIFF(MINUTE, NOW(), (ADDTIME(last_attempt, '0:15:0'))) FROM user_attempt WHERE user_id = ?";
    $result = $con->prepare($sql);

    $result->execute([$user]);

    $temps = $result->fetch();

    return $temps;
}
function resetAttempts($user, $con) {
    $sql = "UPDATE user_attempt SET blocked = 0, attempts = 0 WHERE user_id = ?";
    $result = $con->prepare($sql);

    $result->execute([$user]);
    $result->closeCursor();
}
function getBlockedEtat($user, $con){
    $sql = "SELECT blocked FROM user_attempt WHERE user_id = ?";
    $result = $con->prepare($sql);

    $result->execute([$user]);

    $blocked = $result->fetch();

    return $blocked;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root"; 
    $password = "cegep";
    $dbname = "mydatabase";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = ?";
        $result = $conn->prepare($sql);

        $result->execute([$inputUsername]);

        $user = $result->fetch(PDO::FETCH_ASSOC);

        if(getBlockedEtat($user['user_id'], $conn)[0] == 1){
            if(getTempsBloqueRestant($user['user_id'], $conn)[0] <= 0){
                resetAttempts($user['user_id'], $conn);
            }
        }
        if(getAttempt($user['user_id'], $conn)[0] < 5) {
            if ($inputPassword == $user['password'])
            {
                resetAttempts($user['user_id'], $conn);
                $_SESSION['username'] = $user['username'];
                header("Location: acceuil.php");
                exit();
            } else {
                addAttempt($user['user_id'], $conn);
                $error = "Mauvais mot de passe ou nom d'utilisateur.";
            }
        }
        else{
            $error = "Trop de tentatives de connexion, compte bloqué pendant " . getTempsBloqueRestant($user['user_id'], $conn)[0] . " minutes.";
        }
        header("Location: connexion.php?erreur=".$error."");
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
    $conn = null;
}
?>
