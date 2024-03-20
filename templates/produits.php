<?php

include_once 'libs/modele.php';
include_once 'libs/maLibSecurisation.php';
$products = getProduits();

// var_dump($products); // Cela devrait afficher les résultats ou false si la requête a échoué

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si le champ de recherche a été envoyé dans le formulaire
    if (isset($_POST["search_data"])) {
        // Récupère la valeur du champ de recherche
        $searchData = $_POST["search_data"];    
        // Récupère les produits correspondant à la recherche
        $products = getProduitsRecherche($searchData);
    }
    echo "<div class='search-results'>";
    // Si $products est vide, on affiche le message "Aucun produit trouvé" et affiche tous les produits
    if (empty($products)) {
        $products = getProduits();
        echo "<h3>Aucun produit trouvé pour la recherche : " . htmlspecialchars($searchData) . ", voici le catalogue :</h3>";
    } else {
        //si la première valeur de $product est 1 alors on affiche le message "Résultat de la recherche pour : " . htmlspecialchars($searchData)
        echo "<h3>Vous avez recherché : \"" . htmlspecialchars($searchData) . "\" </h3>";
        if ($products[0] != 1)
            {
                array_shift($products);
                // Vérifier si la valeur de recherche est différente de celle utilisée dans la recherche réelle
                $closestProduct = null;
                $closestDistance = PHP_INT_MAX;

                // Recherche du produit le plus proche en terme de Levenshtein
                foreach ($products as $produit) {
                    $distance = levenshtein($searchData, $produit['designation']);

                    if ($distance < $closestDistance) {
                        $closestProduct = $produit;
                        $closestDistance = $distance;
                    }
                }
                $searchDataUsed = $closestProduct['designation'];
                if ($searchData != $searchDataUsed) {
                    echo "<h4>Voici les résultat pour : " . htmlspecialchars($searchDataUsed) . "</h4>";
                }
            }
        else array_shift($products);
    }
    echo "</div>";
}


?>
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