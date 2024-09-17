<?php
session_start();

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

        $sql = "SELECT * FROM utilisateurs WHERE username = '$inputUsername'";
        $result = $conn->query($sql);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        
        if ($inputPassword == $user['password'])
        {
            $_SESSION['username'] = $user['username'];
            header("Location: acceuil.php");
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }

    $conn = null;
}
?>