
<?php

include_once 'libs/modele.php';
include_once 'libs/maLibSecurisation.php';
$products = getProduits();

// var_dump($products); // Cela devrait afficher les résultats ou false si la requête a échoué

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>
<html lang="en" class="homepageHTML">
<head>
    <title>Homepage</title>
</head>
<body class="homepageBODY">
<div class="background-container">
    <div class="content">
        <h1 class="titresH1">
            Bienvenue Chez Doled :
            <br>Votre Magasin D'Électronique De Confiance Au Maroc
        </h1>
        <p id="sous-titre">Découvrez chez Doled tout ce dont vous rêvez en électronique. <br> Explorez notre catalogue diversifié et profitez d'avantages exclusifs avec notre programme de points de fidélité.</p>
        <div class="actions">
            <a href="index.php?view=produits" class="liensInter">
                <button class="btn1">Voir les Produits</button>
            </a>
            <?php if ($_SESSION['connecte'] == true) { ?>
                <a href="index.php?view=compte_client" class="liensInter">Profitez des Points de Fidélité</a>
            <?php } ?>
            <?php if ($_SESSION['connecte'] == false) { ?>
                <a href="index.php?view=connexion" class="liensInter">Profitez des Points de Fidélité</a>
            <?php } ?>
        </div>
    </div> <!-- .content -->
    <div class="image-container">
        <img id="image-magasin" src="./ressources/magasin.webp" alt="photo du magasin">
    </div> <!-- .image-container -->
</div> <!-- .background-container -->
<!-- les div de la page produit -->
<div class="products-hp">
<?php foreach ($products as $index => $product): ?>
    <?php
        // Limiter l'affichage à 9 produits
        if ($index >= 12) {
            break;
        }

        $quantiteProd = getQuantite($product['id_produit']);
        $quantiteProdMin = getQuantiteMin($product['id_produit']);
        if ($quantiteProd == 0) {
            $affichage = "En rupture de stock";
            $classe = "rouge";
        } elseif ($quantiteProd < $quantiteProdMin) {
            $affichage = "Il ne reste que $quantiteProd exemplaires(s)";
            $classe = "orange";
        } else {
            $affichage = "Disponible";
            $classe = "vert";
        }
    ?>
    <div class="product-card">
        <img src="<?php echo htmlspecialchars($product['image_prod']); ?>" alt="Image du produit" class="product-image">
        <div class="product-details">
            <h3 class="product-name"><?php echo htmlspecialchars($product['designation']); ?></h3>
            <p class="product-price"><?php echo htmlspecialchars($product['prix_unitaire']); ?> dhs</p>
            <p class="product-availability <?php echo $classe; ?>"><?php echo $affichage; ?></p>
            <a href="index.php?view=produit&id=<?php echo $product['id_produit']; ?>" class="product-details-link">Voir les détails</a>
        </div> <!-- .product-details -->
    </div> <!-- .product-card -->
<?php endforeach; ?>
</div> <!-- .products-hp -->
</body>
</html>
