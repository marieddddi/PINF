<?php


// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE");

?>

<link rel="stylesheet" href="css/main.css" /> <!--a enlever a la fin car dans header-->

<body>

    <div id="gauche">
        <h1 id="titreH1"> CONNEXION</h1>
        <p id="sousTitre">Bienvenue sur la page de connexion Doled. Connectez-vous pour accéder à des offres exclusives
            aux membres du site, accumulez vos points de fidélité et obtenez des avantages uniques. </p>
        </br></br></br></br>
        <div id="form">
            <!-- Formulaire de connexion -->
            <form action="controleur.php" method="POST">
                <div class="log"><label for="login"> Identifiant <span class="rouge">*</span></label> <br>
                    <input type="text" class="champText" name="login" placeholder="E-mail ou numéro de téléphone" />
                </div><br />
                <div class="log"><label for="passe">Mot de passe <span class="rouge">*</span></label><br>
                    <input type="password" class="champText" name="passe" placeholder="Mot de passe" />
                    <!--ajout du petit oeuil pour voir son mdp-->

                </div><br />
                <div class="souvenir"><input type="checkbox" name="remember" /><label for="remember"> Se souvenir de
                        moi</label>
                    <a href="index.php?view=mdp_oublie" class="lienInter">Mot de passe oublié ?</a>

                </div> <!--faire la gestion de mdp oublié-->
                <input type="submit" name="action" value="Se connecter" class="btn" />

                <div class="log"><span class="rouge">obligatoire*</span></div>
                </br></br></br></br></br></br>
                <div id="pascompte">
                    Pas de compte ? <br /><a href="index.php?view=inscription">
                        Inscrivez-vous</a>
                </div>
            </form>
        </div>
        <!--si on a un message dans l'url, on l'affiche sur la page: -->
        <?php if (isset($_GET['msg'])) {
            // Récupérer la valeur du paramètre 'msg'
            $message = urldecode($_GET['msg']); // Décoder les caractères spéciaux dans le message
            echo '<div id="message">' . $message . '</div>';
        } ?>
    </div>
   

</body>