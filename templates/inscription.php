<link rel="stylesheet" href="css/main.css" /> <!--a enlever a la fin car dans header-->

<div id="gauche">
	<h1 id="titreH1"> Inscription</h1>
	<p id="sousTitre">Inscrivez-vous dès maintenant pour accéder à des offres exclusives aux membres du site, accumuler
		des points de fidélité et obtenir des avantages uniques. </p>
	</br></br></br></br>

	<div id="form">
		<!-- formulaire d'inscription -->
		<form action="controleur.php" method="POST">
			<div id="coord">
				<div class="log">
					<label for="nom">Nom <span class="rouge">*</span></label><br>
					<input type="text" class="champText1" name="nom" placeholder="Nom" value="" />
				</div><br />
				<div class="log"><label for="prenom">Prénom <span class="rouge">*</span></label><br>
					<input type="text" class="champText2" name="prenom" placeholder="Prénom" value="" />
				</div><br />
			</div>
			<div class="log"><label for="email"> E-mail </label> <br>
				<input type="text" class="champText" name="email" placeholder="votre@email.com" value="" />
			</div><br />
			<div class="log"><label for="num"> Numéro de téléphone <span class="rouge">*</span></label> <br>
				<input type="text" class="champText" name="num" placeholder="Numéro de téléphone" value="" />
			</div><br />
			<div class="log"><label for="passe">Mot de passe <span class="rouge">*</span></label><br>
				<input type="password" class="champText" name="passe" placeholder="Mot de passe" value="" />
			</div>
			<p id="indication">Utilisez au moins huit caractères avec des lettres, des chiffres et des caractères
				spéciaux</p><br />
			<div class="log"><label for="passe2">Confirmer le mot de passe <span class="rouge">*</span></label><br>
				<input type="password" class="champText" name="passe2" placeholder="Mot de passe" value="" />
			</div><br />
			<input type="submit" name="action" value="Confirmer l inscription" class="btn" />

			<div class="log"><span class="rouge">obligatoire*</span></div>
			</br>
			<!-- si l'utilisateur a déjà un compte, on lui propose de se connecter -->
			<div id="dejacompte">
				Vous avez déjà un compte ? <br /><a href="index.php?view=connexion"> Connectez-vous</a>
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

</div>