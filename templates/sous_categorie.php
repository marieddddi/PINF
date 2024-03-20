<?php
include_once 'libs/modele.php';

if (isset($_GET['id'])) {
    $categorie_mere_id = $_GET['id'];
    $catMere = getCategorieMere($categorie_mere_id);
    $catMereNom = getCategorieMereNom($categorie_mere_id);
    $catMereImage = getCategorieMereImage($categorie_mere_id);

    if ($catMereNom) {
        foreach ($catMereNom as $catMereNomm) {
            echo '<body class="catBODY">';
            echo '<div class="deco-cat"><h1 class="titresH1">' . htmlspecialchars($catMereNomm['nom_cat']) . '</h1></div>';
        }
    }

    $sous_categories = getSousCategorie($categorie_mere_id);
    echo'<div class="boxes-cat">';
    if ($sous_categories) {
        foreach ($sous_categories as $sous_categorie) {
            echo '<div class="box-cat" onclick="window.location=\'index.php?view=produits&id=' . htmlspecialchars($sous_categorie['id_cat']) . '\'">';
            echo '<img class="image-cat" src="' . htmlspecialchars($sous_categorie['image_cat']) . '" alt="image de la sous-catégorie">';
            echo '<h2 class="nom-cat">' . htmlspecialchars($sous_categorie['nom_cat']) . '</h2>';
            echo '</div>';
        }
    } else {
        echo '<p>Aucune sous-catégorie trouvée pour cette catégorie.</p>';
    }
    // accès à l'URL de l'image
    $imageUrl = $catMereImage[0]['image_cat'];


    // voir tous les produits de la catégorie mère
    echo '<div class="box-cat" onclick="window.location=\'index.php?view=produits\'">';
    echo '<a href="index.php?view=produits&id=' . $categorie_mere_id . '" class="box-cat-link">';
    echo '<img class="image-cat" src="' . $imageUrl . '" alt="image de la catégorie mère">';
    echo '<h2 class="nom-cat">Voir tous les produits</h2>';
    echo '</a>';
    
    echo '</div>';
    echo '</div>';

    

    echo '</body>';

} else {
    echo '<p>Identifiant de la catégorie non spécifié.</p>';
}
?>
