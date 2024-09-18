<?php
    include "pdo.php";

    $sql = 'UPDATE bombe SET lance = true, temps = NOW() WHERE noBombe = ?';
    $resultat = $con->prepare($sql);

    $resultat->execute([1]);

    header("Location: acceuil.php");
    exit();

    $con = null;
?>