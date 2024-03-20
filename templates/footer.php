<footer>

  <link rel="stylesheet" type="text/css" href="css/main.css">

  <div class="footer-content">
    <div class="footer-section" id="map-link" href="#">
      <h3>ADRESSE</h3>
      <p>Résidence INES</p>
      <p>Hay Qods</p>
      <p>Benslimane</p>
    </div>

    <div class="footer-section">
      <h3>CONTACT</h3>
      <p>06 61 21 50 48</p>
      <p>boukhizzousmc@ymail.com</p>
    </div>
    <div class="footer-section">
      <h3>HORAIRES</h3>
      <p>Lundi - Samedi: 08h30 - 13h00</p>
      <p>14h00 18h00</p>
    </div>
  </div>

  <div class="footer-nav">
    <h3>NAVIGATION</h3>
    <nav>
      <ul>
        <li><a href="index.php?view=homepage">Accueil</a></li>
        <li><a href="index.php?view=produits">Produits</a></li>
        <li><a href="index.php?view=contact">Contact</a></li>
      </ul>
    </nav>
  </div>
  <div class="footer-products">
    <h3 onclick="window.location='index.php?view=categorie'">NOS PRODUITS</h3>
    <?php
    $categories = getCategorieMere();
    $counter = 0;
    foreach ($categories as $categorie):
      if ($counter >= 3) {
        break;
      }
      ?>
      <p
        onclick="window.location='index.php?view=sous_categorie&id=<?php echo htmlspecialchars($categorie['id_cat']); ?>'">
        <?php echo htmlspecialchars($categorie['nom_cat']); ?>
      </p>
      <?php
      $counter++;
    endforeach;
    ?>
  </div>
  <div class="footer-about" href="#" onclick="showPopup(); return false;">

    <h3>A PROPOS</h3>
    <p>Mentions légales</p>
    <p>Protection des données</p>
    <p>Cookies</p>

    <script>
      // Fonction pour afficher la fenêtre pop-up
      function showPopup() {
        document.getElementById("popup-overlay").classList.add("show");

        // Script de la fenêtre pop-up
        document.getElementById('popup-overlay').addEventListener('click', function (event) {
          event.stopPropagation();
        });
      }

      // Fonction pour masquer la fenêtre pop-up
      function hidePopup() {
        document.getElementById("popup-overlay").classList.remove("show");
      }
    </script>
  </div>

  <!-- Fenêtre pop-up -->
  <div id="popup-overlay" class="popup-overlay" onclick="hidePopup();">
    <div class="popup" onclick="event.stopPropagation();">

      <h1>Mentions légales</h1>
      <h2>1. Informations sur l'éditeur du site :</h2>
      <p>"Les Recettes du Chef" est édité par Marie&Martial Industries, une société enregistrée en France, sous le
        numéro 123456789ABCDEFG. Son siège social est situé à LENS.</p>

      <h2>2. Responsable de la publication :</h2>
      <p>Le responsable de la publication du site "Les Recettes du Chef" est Marie&Martial, joignable à
        l'adresse 9 rue Tunis 62300 Lens ou par courriel à l'adresse lesrecettesduchef@gmail.com.</p>

      <h2>3. Hébergement du site :</h2>
      <p>Le site "Les Recettes du Chef" est hébergé par OVH, dont le siège social est situé à
        2 rue Kellermann - 59100 Roubaix - France.</p>

      <h1>Conditions générales</h1>
      <h2>1. Utilisation du site :</h2>
      <p>En accédant et en utilisant le site "Les Recettes du Chef", vous acceptez d'être lié par les présentes
        conditions générales d'utilisation. Toute utilisation non autorisée du site peut entraîner des
        poursuites judiciaires.</p>

      <h2>2. Contenu du site :</h2>
      <p>Le contenu du site "Les Recettes du Chef" est fourni à titre informatif uniquement. Nous nous efforçons
        de maintenir les informations à jour, mais nous ne garantissons pas l'exactitude, l'exhaustivité ou la
        pertinence du contenu. L'utilisation du contenu du site est à vos propres risques.</p>

      <h2>3. Propriété intellectuelle :</h2>
      <p>Tous les droits de propriété intellectuelle relatifs au site et à son contenu, y compris les textes, les
        images, les vidéos, les logos, les marques de commerce, etc., sont la propriété de "Les Recettes du
        Chef" ou de ses partenaires. Toute utilisation non autorisée du contenu est strictement interdite.</p>

      <h1>Contact</h1>
      <p>Pour nous contacter, vous pouvez utiliser les informations suivantes :</p>
      <p>Adresse : 9 rue Tunis 62300 Lens<br>
        Téléphone : 06 40 39 60 36<br>
        E-mail : <a href="mailto:lesrecettesduchef@gmail.com">lesrecettesduchef@gmail.com</a></p>

      <h1>Vie privée</h1>
      <h2>1. Collecte des données personnelles :</h2>
      <p>Nous pouvons collecter certaines données personnelles, telles que votre nom, votre adresse e-mail et
        votre adresse IP, lorsque vous utilisez le site "Les Recettes du Chef". Ces informations seront traitées
        conformément à notre politique de confidentialité.</p>

      <h2>2. Utilisation des données personnelles :</h2>
      <p>Les données personnelles collectées peuvent être utilisées pour vous fournir des informations, des
        services ou du contenu personnalisé liés au site "Les Recettes du Chef". Nous ne partagerons pas vos
        informations personnelles avec des tiers sans votre consentement.</p>

      <h2>3. Sécurité des données :</h2>
      <p>Nous mettons en place des mesures de sécurité appropriées pour protéger vos données personnelles contre
        tout accès non autorisé, toute divulgation ou toute utilisation abusive.</p>

      <input type="button" value="Fermer" onclick="hidePopup();">
    </div>
  </div>

  <div class="footer-copyright">
    <p>DOLED © 2022</p>
  </div>

</footer>
