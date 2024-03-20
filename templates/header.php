<?php
// Si la page est appelée directement par son adresse, on redirige en passant par la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
	header("Location:../index.php");
	die("");
}

// Pose quelques soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");
include_once("libs/maLibSecurisation.php");
?>



<!-- **** H E A D **** -->

<head>
	<meta charset="utf-8" />
	<title>DOLED</title>
	<link rel="icon" type="image/png" href="ressources/icone.png">
	<link rel="stylesheet" href="css/main.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<script src="https://kit.fontawesome.com/c1a715329e.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<!-- à utiliser sur le serveur local
		<script src="ressources/fontawesome-free-6.5.1-web/js/all.min.js"></script>
	-->

</head>

<header>
	<nav id="header-nav">
		<div class="menu-icon">
			<span class="fas fa-bars"></span>
		</div>

		<div class="logo">
			<a href="index.php?view=homepage">
				<img src="ressources/logo.png" alt="Logo" />
			</a>
		</div>

		<div class="nav-items">
			<li><a href="index.php?view=homepage">Accueil</a></li>
			<li><a href="index.php?view=categorie">Catégories</a></li>
			<li><a href="index.php?view=contact">Contact</a></li>

			<?php
			if (isset($_SESSION['id_pers']) && valider("connecte", "SESSION")) {
				if (recupRole($_SESSION['id_pers']) == "0") {
					?>
					<li><a href="index.php?view=compte_admin">Mon compte</a></li>
					<?php
				} elseif (recupRole($_SESSION['id_pers']) == "1") {
					?>
					<li><a href="index.php?view=compte_employe">Mon compte</a></li>
					<?php
				} elseif (recupRole($_SESSION['id_pers']) == "2") {
					?>
					<li><a href="index.php?view=compte_client">Mon compte</a></li>
					<?php
				}
			} else {
				?>
				<li><a href="index.php?view=connexion">Se connecter</a></li>
				<?php
			}
			?>


		</div>

		<div class="search-icon">
			<span class="fas fa-search"></span>
		</div>

		<div class="cancel-icon">
			<span class="fas fa-times"></span>
		</div>

		

		<form action="index.php?view=produits" method="post">
			<input type="search" class="search-data" name="search_data" placeholder="Rechercher" required>
			<button type="submit" class="fas fa-search"></button>
		</form>



	</nav>
	<script>
		const menuBtn = document.querySelector(".menu-icon");
		const searchBtn = document.querySelector(".search-icon");
		const cancelBtn = document.querySelector(".cancel-icon");
		const items = document.querySelector(".nav-items");
		const form = document.querySelector("form");


		menuBtn.onclick = () => {
			if (items.classList.contains("active")) {
				items.classList.remove("active");
				menuBtn.classList.remove("hide");
				searchBtn.classList.remove("hide");
				cancelBtn.classList.remove("show");
			} else {
				items.classList.add("active");
				menuBtn.classList.add("hide");
				searchBtn.classList.add("hide");
				cancelBtn.classList.add("show");
			}
		}

		cancelBtn.onclick = () => {
			items.classList.remove("active");
			menuBtn.classList.remove("hide");
			searchBtn.classList.remove("hide");
			cancelBtn.classList.remove("show");
			form.classList.remove("active");
		}

		searchBtn.onclick = () => {
			form.classList.add("active");
			searchBtn.classList.add("hide");
			cancelBtn.classList.add("show");
		}



	</script>
</header>