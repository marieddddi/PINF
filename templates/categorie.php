<!DOCTYPE html>
<?php

include_once 'libs/modele.php';
$categories = getCategorieMere();

// var_dump($categories); // afficher les résultats ou false si la requête a échoué

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>
<html lang="en" class="catHTML">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
    <title>Catégorie</title>
</head>
<body class="catBODY">
    <div class="deco-cat">
        <h1 class="titresH1">
            Catégories
        </h1>
    </div>
<div class="boxes-cat">
    <?php foreach ($categories as $categorie): ?>
        <div class="box-cat" onclick="window.location='index.php?view=sous_categorie&id=<?php echo htmlspecialchars($categorie['id_cat']); ?>';">
            <img class="image-cat" src="<?php echo htmlspecialchars($categorie['image_cat']); ?>" alt="image de la categorie">
            <h2 class="nom-cat"><?php echo htmlspecialchars($categorie['nom_cat']); ?></h2>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
