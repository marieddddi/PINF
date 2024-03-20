<?php
if (isset($_GET['view']) && $_GET['view'] === 'contact' && isset($_GET['success']) && $_GET['success'] === 'true') {
  echo '
  <div class="contact-container">
  <p>Le message a été envoyé avec succès</p>
  <a href="index.php">Retour à l\'accueil</a>
  </div>';
  
} else if (isset($_GET['view']) && $_GET['view'] === 'contact' && isset($_GET['success']) && $_GET['success'] === 'false') {
  echo '
  <div class="contact-container">
  <p>Une erreur est survenue lors de l\'envoi du message</p>
  <a href="index.php">Retour à l\'accueil</a>
  <a href="index.php?view=contact">Retour au formulaire de contact</a>
  </div>';
} else { ?>
    <body>
      <div class="contact-container">
        <h1>Nous contacter</h1>
        <form action="index.php?view=send_email" method="post">
          <label for="name">Nom:</label><br>
          <input type="text" id="name" name="name" required><br>
          <label for="email">Email:</label><br>
          <input type="email" id="email" name="email" required><br>
          <label for="message">Message:</label><br>
          <textarea id="message" name="message" rows="4" cols="50" required></textarea><br>
          <input type="submit" value="Envoyer">
        </form>
      </div>
    </body>
<?php }

?>