<?php

$servername = "localhost";
    $username = "root"; 
    $password = "cegep";
    $dbname = "mydatabase";

try{
    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die("Connexion échouée. Erreur : " . $e->getMessage());
    
}

?>
