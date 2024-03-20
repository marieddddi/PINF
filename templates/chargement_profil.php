<?php
include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php";
include_once "libs/modele.php";

if (isset($_POST['currentIndex'])) {

    $currentIndex = intval($_POST['currentIndex']);
    $resultats = listeEmployes($currentIndex, 4);

    foreach ($resultats as $unResultat) {
        echo "<div class='profil'>";
        echo "   <img src='ressources/profil.png' class='photo'>";
        echo "   <p class='identite'><strong>" . $unResultat["nom"] . " " . $unResultat["prenom"] . "</strong></p>";
        echo "   <p class='role'>" . $unResultat["nom_role"] . "</p>";
        echo "</div>";
    }
}
?>