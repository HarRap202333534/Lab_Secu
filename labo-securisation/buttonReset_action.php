<?php
    include "pdo.php";

    $sql = 'UPDATE bombe SET lance = false WHERE noBombe = ?';
    $resultat = $con->prepare($sql);

    $resultat->execute([1]);

    $resultat->closeCursor();
    $con = null;

    header("Location: acceuil.php");
?>