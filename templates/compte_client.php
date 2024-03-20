<?php

include_once 'libs/modele.php';
include_once 'libs/maLibSecurisation.php';

// on réccupère l'id de l'utilisateur connecté
if ($_SESSION['connecte'] == true) {
    $id = $_SESSION['id_pers'];
}
$users = infoUser($id); // renvoie un tableau voici la fonction infoUser function infoUser($id){
echo "test";
?>
<link rel="stylesheet" href="./css/main.css">
<div class="compte-client">
    <h2 class="titreH2">Points de fidélité</h2>
    <div class="pts-fidelite">
        <div class="progress-bar-fill-text">Vous avez
            <?php echo $users[0]['points_fidelite']; ?> points
        </div>
        <div class="multi-step-progress-bar">

            <div class="progress-bar-fill"
                style="width: <?php echo min(100, ($users[0]['points_fidelite'] / 10000) * 100); ?>%;">

            </div>
            <!-- Marqueurs pour chaque jauge -->

            <div class="progress-step" data-step="200" style="left: <?php echo (200 / 10000) * 100; ?>%"></div>
            < <div class="progress-step" data-step="1000" style="left: <?php echo (1000 / 10000) * 100; ?>%">
        </div>
        <div class="progress-step" data-step="2500" style="left: <?php echo (2500 / 10000) * 100; ?>%"></div>
        <div class="progress-step" data-step="5000" style="left: <?php echo (5000 / 10000) * 100; ?>%"></div>
        <div class="progress-step" data-step="7500" style="left: <?php echo (7500 / 10000) * 100; ?>%"></div>
        <div class="progress-step" data-step="10000" style="left: 97%"></div>
    </div>
</div>
</div>
<h2 class="titreH2">Paramètres du compte</h2>
<div class="coordonnees-client-conteneur">
    <div class="coordonnees-client">
        <div class="section-titre">
            <h3 class="titre-interne">Données personnelles</h3>
            <span class="btn-interne" onclick="toggleEdit(this)"><i class="fa fa-pencil"></i> Modifier</span>
        </div>
        <div id="personal-data-view">
            <p class="coordonnees-client-label"><label class="sous-titre">Nom</label> <br><br>

                <span id="nom-view">
                    <?php echo htmlspecialchars($users[0]['nom']); ?>
                </span>
            </p>
            <p class="coordonnees-client-label"><label class="sous-titre">Prénom</label><br><br>
                <span id="prenom-view">
                    <?php echo htmlspecialchars($users[0]['prenom']); ?>
                </span>
            </p>
        </div>
        <div id="personal-data-edit-nom" style="display:none;">
            <label class="coordonnees-client-label" for="nom">Nom</label>
            <input class="coordonnees-client-input" type="text" id="nom-edit"
                value="<?php echo htmlspecialchars($users[0]['nom']); ?>">
            <label class="coordonnees-client-label" for="prenom">Prénom</label>
            <input class="coordonnees-client-input" type="text" id="prenom-edit"
                value="<?php echo htmlspecialchars($users[0]['prenom']); ?>">
            <button class="btn-save coord" id="btn-save-NP" name="action" value="modifierNomPrenom">Sauvegarder</button>
        </div>
    </div>
    <div class="coordonnees-client">
        <div class="section-titre">
            <h3 class="titre-interne">E-mail</h3>
            <span class="btn-interne" onclick="toggleEdit(this)"><i class="fa fa-pencil"></i> Modifier</span>
        </div>
        <div id="personal-data-view">
            <p class="coordonnees-client-label"><label class="sous-titre">Adresse e-mail</label> <br><br>
                <span id="mail-view">
                    <?php echo htmlspecialchars($users[0]['mail']); ?>
                </span>
            </p>
        </div>
        <div id="personal-data-edit-mail" style="display:none;">
            <label class="coordonnees-client-label" for="adresse-mail">Adresse-mail</label>
            <input class="coordonnees-client-input" type="text" id="mail-edit"
                value="<?php echo htmlspecialchars($users[0]['mail']); ?>">
            <button class="btn-save mail" id="btn-save-mail" name="action" value="modifierMail">Sauvegarder</button>
        </div>
    </div>
    <div class="coordonnees-client">
        <div class="section-titre">
            <h3 class="titre-interne">Numéro de téléphone</h3>
            <span class="btn-interne" onclick="toggleEdit(this)"><i class="fa fa-pencil"></i> Modifier</span>
        </div>
        <div id="personal-data-view">
            <p class="coordonnees-client-label"><label class="sous-titre">Numéro de téléphone</label> <br><br>
                <span id="phone-view">
                    <?php echo htmlspecialchars($users[0]['num_telephone']); ?>
                </span>
            </p>
        </div>
        <div id="personal-data-edit-telephone" style="display:none;">
            <label class="coordonnees-client-label" for="numero">Numéro de téléphone</label>
            <input class="coordonnees-client-input" type="text" id="phone-edit"
                value="<?php echo htmlspecialchars($users[0]['num_telephone']); ?>">
            <button class="btn-save telephone" id="btn-save-telephone" name="action"
                value="modifierPhone">Sauvegarder</button>
        </div>
    </div>
    <div class="coordonnees-client">
        <div class="section-titre">
            <h3 class="titre-interne">Adresse du domicile</h3>
            <span class="btn-interne" onclick="toggleEdit(this)"><i class="fa fa-pencil"></i> Modifier</span>
        </div>
        <div id="personal-data-view">
            <p class="coordonnees-client-label"><label class="sous-titre">Adresse </label> <br><br>
                <span id="adresse-view">
                    <?php echo htmlspecialchars($users[0]['adresse']); ?>
                </span>
            </p>
        </div>
        <div id="personal-data-edit-adresse" style="display:none;">
            <label class="coordonnees-client-label" for="adresse">Adresse</label>
            <input class="coordonnees-client-input" type="text" id="adresse-edit"
                value="<?php echo htmlspecialchars($users[0]['adresse']); ?>">
            <button class="btn-save adresse" name="action" id="btn-save-adresse"
                value="modifierAdreses">Sauvegarder</button>
        </div>
    </div>
</div>
<form action="controleur.php" method="post">
    <input type="hidden" name="action" value="Logout">
    <button class="btn1" type="submit">Déconnexion</button>
</form>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function toggleEdit(buttonElement) {
        var parentDiv = buttonElement.closest(".coordonnees-client");
        var viewDiv = parentDiv.querySelector("#personal-data-view");
        var editDiv = parentDiv.querySelector("[id^='personal-data-edit']"); // Trouve le div dont l'ID commence par 'personal-data-edit'
        if (viewDiv.style.display !== "none") {
            viewDiv.style.display = "none";
            editDiv.style.display = "block";
        } else {
            viewDiv.style.display = "block";
            editDiv.style.display = "none";
        }
    }

    $("#btn-save-NP").click(function () {
        var formData = {
            'action': 'modifierNomPrenom',
            'id': <?php echo json_encode($_SESSION['id_pers']); ?>,
            'nom': $("#nom-edit").val(),
            'prenom': $("#prenom-edit").val()
        };

        $.ajax({
            type: "POST",
            url: "controleur.php",
            data: formData,
            success: function (data) {
                alert("Informations mises à jour avec succès !");
                // Mettre à jour l'affichage des informations ici ou recharger la page pour voir les modifications
                location.reload();
            },
            error: function () {
                alert("Erreur lors de la mise à jour des informations.");
            }
        });
    });

    $("#btn-save-mail").click(function () {
        var formData = {
            'action': 'modifierMail',
            'id': <?php echo json_encode($_SESSION['id_pers']); ?>,
            'mail': $("#mail-edit").val()
        };

        $.ajax({
            type: "POST",
            url: "controleur.php",
            data: formData,
            success: function (data) {
                alert("Informations mises à jour avec succès !");
                // Mettre à jour l'affichage des informations ici ou recharger la page pour voir les modifications
                location.reload();
            },
            error: function () {
                alert("Erreur lors de la mise à jour des informations.");
            }
        });
    });

    $("#btn-save-telephone").click(function () {
        var formData = {
            'action': 'modifierNum',
            'id': <?php echo json_encode($_SESSION['id_pers']); ?>,
            'num': $("#phone-edit").val()
        };

        $.ajax({
            type: "POST",
            url: "controleur.php",
            data: formData,
            success: function (data) {
                alert("Informations mises à jour avec succès !");
                // Mettre à jour l'affichage des informations ici ou recharger la page pour voir les modifications
                location.reload();
            },
            error: function () {
                alert("Erreur lors de la mise à jour des informations.");
            }
        });
    });

    $("#btn-save-adresse").click(function () {
        var formData = {
            'action': 'modifierAdresse',
            'id': <?php echo json_encode($_SESSION['id_pers']); ?>,
            'adresse': $("#adresse-edit").val()
        };

        $.ajax({
            type: "POST",
            url: "controleur.php",
            data: formData,
            success: function (data) {
                alert("Informations mises à jour avec succès !");
                // Mettre à jour l'affichage des informations ici ou recharger la page pour voir les modifications
                location.reload();
            },
            error: function () {
                alert("Erreur lors de la mise à jour des informations.");
            }
        });
    });

</script>