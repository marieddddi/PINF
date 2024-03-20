<?php
include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php";
include_once "libs/modele.php";

if ($_GET['id'] == -1) { ?>
    <div class="ensemble">
        <?php
        echo "<h1 class='log'>Ajouter un employé</h1>";
        echo "</br></br></br>";
        ?>
        <form action="controleur.php?id=-1" method="POST">
            <div class="flex-container">
                <div class="gauche1">
                    <div class="log"><label for="nom">Nom </label><br>
                        <input type="text" class="champText4" name="nom" placeholder="Nom" />
                    </div><br />
                    <div class="log"><label for="prenom">Prénom </label><br>
                        <input type="text" class="champText4" name="prenom" placeholder="Prénom" />
                    </div><br />
                    <div class="log"><label for="adresse">Adresse </label><br>
                        <input type="text" class="champText4" name="adresse" placeholder="Adresse" />
                    </div><br />
                    <div class="log"><label for="mail">Mail </label><br>
                        <input type="text" class="champText4" name="mail" placeholder="Mail" />
                    </div><br />
                </div>
                <div class="droite1">
                    <div class="log"><label for="num_telephone">Numéro de téléphone </label><br>
                        <input type="text" class="champText4" name="num_telephone" placeholder="Numéro de téléphone" />
                    </div><br />
                    <div class="log"><label for="points_fidelite">Points de fidélité </label><br>
                        <input type="text" class="champText4" name="points_fidelite" placeholder="Points de fidélité" />
                    </div><br />
                    <div class="log"><label for="mdp">Mot de passe </label><br>
                        <input type="password" class="champText4" name="mdp" placeholder="Mot de passe" />
                    </div><br />
                    <div class="log"><label for="mdp2">Confirmer le mot de passe </label><br>
                        <input type="password" class="champText4" name="mdp2" placeholder="Confirmer le mot de passe" />
                    </div><br />
                </div>
            </div>
            <input type="submit" id="btn4" value="Ajouter un employe" name="action" />
    </div>
    </form>
    <?php
} else {

    echo '<div class="ensemble">';
    echo "<h1 class='log'>Modifier les coordonnées de l'employé</h1>";
    echo "</br></br></br>";
    // Récupérez l'identifiant de l'employé à partir de l'URL
    $idEmploye = $_GET['id'];

    // Récupérez les informations de l'employé à partir de la base de données en fonction de son identifiant
    $employe = infoUser($idEmploye);
    $table = json_encode($employe);
    $tableArray = json_decode($table, true);
    $nom = $tableArray[0]['nom'];
    $prenom = $tableArray[0]['prenom'];
    $adresse = $tableArray[0]['adresse'];
    $mail = $tableArray[0]['mail'];
    $num_telephone = $tableArray[0]['num_telephone'];
    $points_fidelite = $tableArray[0]['points_fidelite'];



    // Vérifiez si l'employé existe

    // Affichez les informations de l'employé dans un formulaire de modification
    ?>
    <form action="controleur.php?id=<?php echo $idEmploye; ?>" method="POST">
        <div class="flex-container">
            <div class="gauche1">
                <div class="log"><label for="nom">Nom </label><br>
                    <input type="text" class="champText4" name="nom" placeholder="Nom" value="<?php echo $nom ?>" />
                </div><br />
                <div class="log"><label for="prenom">Prénom </label><br>
                    <input type="text" class="champText4" name="prenom" placeholder="Prénom"
                        value="<?php echo $prenom ?>" />
                </div><br />
                <div class="log"><label for="adresse">Adresse </label><br>
                    <input type="text" class="champText4" name="adresse" placeholder="Adresse"
                        value="<?php echo $adresse ?>" />
                </div><br />
                <div class="log"><label for="mail">Mail </label><br>
                    <input type="text" class="champText4" name="mail" placeholder="Mail" value="<?php echo $mail ?>" />
                </div><br />
            </div>
            <div class="droite1">
                <div class="log"><label for="num_telephone">Numéro de téléphone </label><br>
                    <input type="text" class="champText4" name="num_telephone" placeholder="Numéro de téléphone"
                        value="<?php echo $num_telephone ?>" />
                </div><br />
                <div class="log"><label for="points_fidelite">Points de fidélité </label><br>
                    <input type="text" class="champText4" name="points_fidelite" placeholder="Points de fidélité"
                        value="<?php echo $points_fidelite ?>" />
                </div><br />
                <div class="log"><label for="mdp">Mot de passe </label><br>
                    <input type="password" class="champText4" name="mdp" placeholder="Mot de passe" />
                </div><br />
            </div>
        </div>
        <input type="submit" id="btn4" value="Valider la modification" name="action" />
        </div>
    </form>


    <?php

}
?>

<?php if (isset($_GET['msg'])) {
    // Récupérer la valeur du paramètre 'msg'
    $message = urldecode($_GET['msg']); // Décoder les caractères spéciaux dans le message
    echo '<div id="message">' . $message . '</div>';
} ?>