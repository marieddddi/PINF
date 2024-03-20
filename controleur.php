<?php
session_start();

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php";
include_once "libs/modele.php";

$qs = $_POST;

if ($action = valider("action")) {
	ob_start();
	echo "Action = '$action' <br />";
	// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
	// A EVITER si on ne maitrise pas ce type de problématiques



	// Un paramètre action a été soumis, on fait le boulot...
	switch ($action) {
		// Connexion //////////////////////////////////////////////////
		case 'Se connecter':
			$qs = array("view" => "homepage");
			// On verifie la presence des champs login et passe
			if (($login = valider("login")) && ($passe = valider("passe"))) {
				// On verifie l'utilisateur, 
				// et on crée des variables de session si tout est OK
				if (verifUser($login, $passe)) {
					if (valider("remember")) {
						setcookie("login", $login, time() + 60 * 60 * 24 * 30);
						setcookie("passe", $password, time() + 60 * 60 * 24 * 30);
						setcookie("remember", true, time() + 60 * 60 * 24 * 30);
					} else {
						setcookie("login", "", time() - 3600);
						setcookie("passe", "", time() - 3600);
						setcookie("remember", false, time() - 3600);

					}
				} else {
					$qs = array("msg" => " Pseudo ou mot de passe incorrect", "view" => "connexion");
					break;
				}
			} else {
				$qs = array("msg" => " Veuillez remplir tous les champs obligatoires", "view" => "connexion");
				break;
			}


			// On affiche deconnexion    ?>

			<?php
			break;




		case 'Logout':
			// traitement métier
			session_destroy();
			$qs = array("msg" => "Déconnexion réussie", "view" => "homepage");
			break;



		case "Confirmer l inscription":
			$nom = valider("nom");
			$prenom = valider("prenom");
			$mail = valider("email");
			$num = valider("num");
			$passe = valider("passe");
			$passe2 = valider("passe2");



			// Valider l'email
			if (!validateMail($mail)) {
				$qs = array("msg" => " adresse email non valide", "view" => "inscription");
				break;
			}

			//verifier si les mots de passes correspondent 
			if ($passe != $passe2) {
				$qs = array("msg" => " Les mots de passe ne correspondent pas", "view" => "inscription");
				break;
			}

			if (!verifMdp($passe)) {
				$qs = array("msg" => " Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un caractère spécial", "view" => "inscription");
				break;
			}
			//verifier si le num de tel est unqiue 
			if (verifnum($num)) {
				$qs = array("msg" => " Ce numéro de téléphone est déjà utilisé", "view" => "inscription");
				break;
			}
			//verifier si l'utilisateur a bien entré un nom,prenom, mdp et num
			if (empty ($nom) || empty ($prenom) || empty ($passe) || empty ($mail)) {
				$qs = array("msg" => " Veuillez completer les champs obligatoires", "view" => "inscription");
				break;
			}
			//si tout est bon, on créait le compte 
			else {
				creer_compte($nom, $prenom, $passe, $num, $mail);
				$qs = array("view" => "homepage");
				break;
			}






		case "Mon compte":
			$qs = array("view" => "mon_compte");
			break;


		case "ValiderModificationCompte":
			$qs = array("view" => "homepage");
			$qs["msg"] = "Compte modifié avec succès";
			$qs["msgType"] = "success";
			$qs["msgTitle"] = "Succès";
			$qs["msgIcon"] = "check";

			$login = valider("login");
			$passe = valider("passe");
			$passe2 = valider("passe2");
			$nom = valider("nom");
			break;

		case "Ajouter le produit":

			$designation = valider("designation");
			$image = valider("image");
			$num_serie = valider("num_serie");
			$prix = valider("prix");
			$description = valider("description");
			$datasheet = valider("datasheet");
			$id_marque = valider("id_marque");
			$id_categorie = valider("id_categorie");
			$stock = valider("stock");
			if ($id_marque == "nouveau") {
				$id_marque = 0;
			}
			if ($id_categorie == "nouveau") {
				$id_categorie = 0;
			}
			if (empty ($designation) || empty ($image) || empty ($num_serie) || empty ($prix) || empty ($description) || empty ($datasheet)) {
				$qs = array("msg" => "Veuillez remplir tous les champs obligatoires", "view" => "ajout_produit");
				break;
			} else {
				$id = creer_produit($designation, $image, $num_serie, $prix, $description, $datasheet, $id_marque, $id_categorie);

				creer_stock($stock, $id);
				$qs = array("msg" => "Ajout réalisé avec succès !", "view" => "compte_admin");
				break;
			}

		case "creerMarque":
			$nom_marque = valider("nom_marque");
			$origine = valider("origine");
			$informations = valider("informations");


			if (empty ($nom_marque) || empty ($origine) || empty ($informations)) {
				$qs = array("msg" => "Veuillez remplir tous les champs obligatoires", "view" => "ajout_produit");
				break;
			} else {
				$nouvelleMarqueId = creer_marque($nom_marque, $origine, $informations);

				// Utilisez $nouvelleMarqueId comme nécessaire ici
				echo json_encode(array("id_marque" => $nouvelleMarqueId, "nom_marque" => $nom_marque));
				exit; // Assurez-vous de terminer le script après l'envoi de la réponse JSON
			}


		case "creerCategorie":
			$nom_categorie = valider("nom_cat");
			$descriptif = valider("descriptif_cat");
			$image = valider("image_cat");
			$sousCat = valider("sous_cat");



			if (empty ($nom_categorie) || empty ($descriptif) || empty ($image)) {
				$qs = array("msg" => "Veuillez remplir tous les champs obligatoires", "view" => "ajout_produit");
				break;
			} else {
				if ($sousCat == -1)
					$nouvelleCatId = creer_categorieMere($nom_categorie, $descriptif, $image);
				else
					$nouvelleCatId = creer_categorie($nom_categorie, $descriptif, $image, $sousCat);
				// Utilisez $nouvelleMarqueId comme nécessaire ici
				echo json_encode(array("id_cat" => $nouvelleCatId, "nom_cat" => $nom_categorie));
				exit; // Assurez-vous de terminer le script après l'envoi de la réponse JSON
			}

		case "supprimerProduit":
			$id_produit = valider("id_produit");
			// Supprimer le produit avec l'ID $id_produit
			supprimer_stock($id_produit);
			supprimer_produit($id_produit);
			break;

		case "supprimerEmploye":
			$id_user = valider("id_user");
			// Supprimer l'employe avec l'ID $id_user
			supprimer_employe($id_user);
			break;

		case "modifier_produit":
			$colonne = valider("colonne");
			$valeur = valider("valeur");
			$id_produit = valider("id");
			if ($colonne == "prix_ht") {
				$colonne = "prix_unitaire";
			}
			if ($colonne == "prix_ttc") {
				$valeur = $valeur / 1.2;
				$colonne = "prix_unitaire";
			}
			if ($colonne == "stock")
				modifierStock($id_produit, $valeur);
			else
				modifierProduit($id_produit, $colonne, $valeur);
			break;


		case "modifier_promotion":
			$id_produit = valider("id");
			$valeur = valider("promotion");
			modifierProduit($id_produit, "promotion", $valeur);
			break;



		case "Valider la modification":
			$nom = valider("nom");
			$prenom = valider("prenom");
			$mdp = valider("mdp");
			$mail = valider("mail");
			$num = valider("num_telephone");
			$adresse = valider("adresse");
			$points_fidelite = valider("points_fidelite");
			$id = valider("id");
			modifier_user($id, $nom, $prenom, $adresse, $mail, $num, $points_fidelite, $mdp);
			break;

		case "Ajouter un employe":
			$nom = valider("nom");
			$prenom = valider("prenom");
			$adresse = valider("adresse");
			$mail = valider("mail");
			$num = valider("num_telephone");
			$points = valider("points_fidelite");
			$mdp = valider("mdp");
			$mdp2 = valider("mdp2");
			$id = valider("id");
			if ($mdp != $mdp2) {
				$qs = array("msg" => " Les mots de passe ne correspondent pas", "view" => "modifier_coordonnees", "id" => $id);
				break;
			}
			if (!verifMdp($mdp)) {
				$qs = array("msg" => " Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un caractère spécial", "view" => "modifier_coordonnees", "id" => $id);
				break;
			}
			if (empty ($nom) || empty ($prenom) || empty ($mail) || empty ($num) || empty ($adresse)) {
				$qs = array("msg" => " Veuillez remplir tous les champs obligatoires", "view" => "modifier_coordonnees", "id" => $id);
				break;
			} else {
				creer_employe($nom, $prenom, $adresse, $mail, $num, $points, $mdp);
				$qs = array("msg" => "Ajout réalisé avec succès !", "view" => "compte_admin");
				break;
			}

		case "modifier_fidelite":
			$id = valider("id");
			$valeur = valider("valeur");
			//conversion montant en points de fidelité -> 100 Dhs =1 point a modifier si besoin
			$total = $valeur + getFidelite($id);
			modifierFidelite($id, $total);
			break;
		case "supprimer_points":
			$id = valider("id");
			$valeur = valider("valeur");
			modifierFidelite($id, $valeur);
			break;
		case "supprimerEmploye":
			$id = valider("id");
			supprimer_employe($id);
			break;
		case "modifierNomPrenom":
			$id = valider("id");
			$nom = valider("nom");
			$prenom = valider("prenom");
			modifierNom($id, $nom);
			modifierPrenom($id, $prenom);
			break;
		case "modifierMail":
			$id = valider("id");
			$mail = valider("mail");
			modifierMail($id, $mail);
			break;
		case "modifierAdresse":
			$id = valider("id");
			$adresse = valider("adresse");
			modifierAdresse($id, $adresse);
			break;
		case "modifierNum":
			$id = valider("id");
			$num = valider("num");
			modifierNum($id, $num);
			break;
		case "supprimer_points":
			$id = valider("id");
			$valeur = valider("valeur");
			modifierFidelite($id, $valeur);
			break;





	}

}

// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";

// On redirige vers la page index avec les bons arguments

//header("Location:" . $urlBase . $qs);
rediriger($urlBase, $qs);

// On écrit seulement après cette entête
ob_end_flush();

?>