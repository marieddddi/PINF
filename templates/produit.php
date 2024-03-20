<?php
include_once 'libs/modele.php';
// // Vérifier si l'utilisateur est connecté et récupérer son identifiant depuis la session
// $id_utilisateur = $_SESSION['id_utilisateur']; // C'est un exemple, veuillez utiliser votre propre méthode pour récupérer l'identifiant de l'utilisateur connecté

// // Ajouter le produit aux favoris dans la base de données

// ajouterAuxFavoris($id_utilisateur, $id_produit);


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = getProduitById($product_id);

    if ($product) {
        $productDetails = $product[0];
        
        // Affichage des détails du produit
        echo '<div class="product-container">';
        echo '<div class="product-image-container">';
        echo '<img class="product-image" src="'.htmlspecialchars($productDetails['image_prod']).'" alt="Image du produit">';
        echo '</div>';
        echo '<div class="product-details-container">';
        echo '<h1 class="product-designation">' . htmlspecialchars($productDetails['designation']) . '</h1>';
        echo '<h4 class="product-serial-number">' . htmlspecialchars($productDetails['num_serie']) . '</h4>';
        echo '<h3 class="product-price">' . htmlspecialchars($productDetails['prix_unitaire']) . ' dhs</h3>';
        echo '<p class="product-description">' . htmlspecialchars($productDetails['descriptif_produit']) . '</p>';
        echo '<a class="product-datasheet-link" href="'.htmlspecialchars($productDetails['datasheet']).'">Lien de la datasheet</a>';
        
        // Affichage de la disponibilité
        $quantiteProd = getQuantite($product_id);
        $quantiteProdMin = getQuantiteMin($product_id);
        $classe = ($quantiteProd == 0) ? 'rouge' : (($quantiteProd < $quantiteProdMin) ? 'orange' : 'vert');
        $affichage = ($quantiteProd == 0) ? 'En rupture de stock' : (($quantiteProd < $quantiteProdMin) ? "Il ne reste que $quantiteProd exemplaire(s)" : 'Disponible');
        echo '<p><span class="' . $classe . '">' . $affichage . '</span></p>';
        // bouton favoris
        // if ($_SESSION['connecte'] == true) {
        //     echo '<div class="bouton-favoris-div">';
        //     echo '<bouton onclick="window.location=\'index.php?view=connexion\'" class="bouton-favoris"><i class="fa-solid fa-heart"></i> Ajouter aux favoris</bouton>';
        //     echo '</div>;'
        // }
        // else{
        //     echo '<bouton class="bouton-favoris"><i class="fa-solid fa-heart"></i> Ajouter aux favoris</bouton>';
        // }
        echo '</div>';
        echo '</div>';
        
        // Affichage des produits de la même catégorie
        $idCat = htmlspecialchars($productDetails['id_cat']);
        $productsCat = getProduitByCat($idCat);
        if ($productsCat) {
            echo '<div class="product-container-carousell">';
            $count = 0; // Initialisation du compteur
            foreach ($productsCat as $productCatDetails) {
                if ($productCatDetails['id_produit'] != $product_id) {
                    echo '<div class="product-card-carousell" onclick="window.location=\'index.php?view=produit&id=' . $productCatDetails['id_produit']. '\'">';
                    echo '<img class="product-image-carousell" src="'.htmlspecialchars($productCatDetails['image_prod']).'" alt="Image du produit">';
                    echo '<div class="product-details">';
                    echo '<h4 class="product-serial-number">' . htmlspecialchars($productCatDetails['designation']) . '</h4>';
                    echo '</div>';
                    echo '</div>';
                    $count++; // Incrémenter le compteur
                    if ($count >= 8) break; // Sortir de la boucle si 8 produits ont été affichés
                }
            }
            echo '</div>';
        }
    } else {
        echo '<p>Produit non trouvé.</p>';
    }
} else {
    echo '<p>Identifiant du produit non spécifié.</p>';
}
?>
<!-- JavaScript pour le carrousel -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.product-container-carousell');

    // Supposons que tous les éléments du carrousel ont la même largeur et des marges uniformes
    const slideWidth = document.querySelector('.product-card-carousell').offsetWidth;
    const slideMarginRight = parseInt(window.getComputedStyle(document.querySelector('.product-card-carousell')).marginRight);

    console.log('slideWidth:', slideWidth); // Vérifiez la valeur de slideWidth
});
</script>
