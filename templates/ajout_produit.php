<?php
//on creer un formulaire pour ajouter un nouvau produit

//on recupere les categories et les marques pour les afficher dans le formulaire
$categories = listeCategories();
$marques = listeMarques();
$categoriesJSON = json_encode($categories);
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div id="formGauche" class="left-section">
    <h1 id="titreH1"> Ajouter un produit</h1>
    <p id="sousTitre">Ajoutez un nouveau produit à la base de données. </p>
    </br></br></br></br>
    <div id="form">
        <!-- formulaire d'ajout de produit -->
        <form action="controleur.php" method="POST">
            <div class="log"><label for="designation">Désignation <span class="rouge">*</span></label><br>
                <input type="text" class="champText3" name="designation" placeholder="Désignation" value="" />
            </div><br />
            <div class="log"><label for="image">Image <span class="rouge">*</span></label><br>
                <input type="text" class="champText3" name="image" placeholder="URL de l'image" value="" />
            </div><br />
            <div class="log"><label for="num_serie">Numéro de série <span class="rouge">*</span></label><br>
                <input type="text" class="champText3" name="num_serie" placeholder="Numéro de série" value="" />
            </div><br />
            <div class="log"><label for="prix">Prix unitaire <span class="rouge">*</span></label><br>
                <input type="text" class="champText3" name="prix" placeholder="Prix unitaire" value="" />
            </div><br />
            <div class="log"><label for="description">Description <span class="rouge">*</ span></label><br>
                <input type="text" class="champText3" name="description" placeholder="Description" value="" />
            </div><br />
            <div class="log"><label for="datasheet">Datasheet <span class="rouge">*</span></label><br>
                <input type="text" class="champText3" name="datasheet" placeholder="URL de la datasheet" value="" />
            </div><br />
            <div class="log"><label for="stock">Stock <span class="rouge">*</span></label><br>
                <input type="number" class="champText3" name="stock" placeholder="Stock" value="" />
            </div>
            <div class="log"><label for="id_marque">Marque </label><br>
                <select name="id_marque" id="id_marque">
                    <?php
                    foreach ($marques as $marque) {
                        echo "<option value='" . $marque["id_marque"] . "'>" . $marque["nom_marque"] . "</option>";
                    }
                    ?>
                    <option value="nouveau">Nouvelle marque</option>
                </select>
            </div><br />
            <div class="log"><label for="id_categorie">Catégorie </label><br>
                <select name="id_categorie" id="id_categorie">
                    <?php
                    foreach ($categories as $categorie) {
                        echo "<option value='" . $categorie["id_cat"] . "'>" . $categorie["nom_cat"] . "</option>";
                    }
                    ?>
                    <option value="nouveau">Nouvelle catégorie</option>
                </select>
            </div><br />
            <input type="submit" name="action" value="Ajouter le produit" class="btn3" />

            <div class="log"><span class="rouge">obligatoire*</span></div>
            </br>

        </form>
    </div>

    <!--si on a un message dans l'url, on l'affiche sur la page: -->
    <?php if (isset($_GET['msg'])) {
        // Récupérer la valeur du paramètre 'msg'
        $message = urldecode($_GET['msg']); // Décoder les caractères spéciaux dans le message
        echo '<div id="message">' . $message . '</div></br>';
    } ?>
</div>
<div id="droite" class="right-section"></div>



<script>
    // Attendre que le document soit prêt
    $(document).ready(function () {
        // Sélectionner les éléments pertinents
        var selectMarque = $('#id_marque');
        var selectCategorie = $('#id_categorie');
        var divDroite = $('#droite');


        // Ajouter un écouteur d'événement au changement du select de marque
        selectMarque.on('change', function () {
            // Vérifier si l'option sélectionnée est "nouveau"
            if ($(this).val() === 'nouveau') {
                // Afficher le formulaire de création de nouvelle marque
                divDroite.html('<h1 id="titreH1">Nouvelle Marque</h1></br></br></br></br></br></br><form id="formMarque" class="form-droite">' +
                    '<label for="nom_marque">Nom de la marque</label>' +
                    '<input type="text" name="nom_marque" class="champtext" placeholder="Nom de marque" required>' +
                    '<label for="origine">Origine de la marque</label>' +
                    '<input type="text" name="origine" class="champtext" placeholder="Origine" required>' +
                    '<label for="informations">Informations sur la marque</label>' +
                    '<input type="text" name="informations" class="champtext" placeholder="Informations" required>' +
                    '<input type="submit" value="Créer la marque" class="btn">' +
                    '</form>');
            } else {
                // Sinon, masquer le formulaire de création de nouvelle marque
                divDroite.empty();
            }
        });

        // Ajouter un écouteur d'événement au changement du select de catégorie
        selectCategorie.on('change', function () {
            console.log($(this).val());
            // Vérifier si l'option sélectionnée est "nouveau"
            if ($(this).val() === 'nouveau') {
                // Afficher le formulaire de création de nouvelle catégorie
                divDroite.html('<h1 id="titreH1">Nouvelle Catégorie</h1></br></br></br></br></br></br><form id="formCategorie" class="form-droite">' +
                    '<label for="nom_cat">Nom de la catégorie</label>' +
                    '<input type="text" name="nom_cat" class="champtext" placeholder="Nom de catégorie" required>' +
                    '<label for="descriptif_cat">Descriptif de la catégorie</label>' +
                    '<input type="text" name="descriptif_cat" class="champtext" placeholder="Descriptif" required>' +
                    '<label for="image_cat">URL de l\'image de la catégorie</label>' +
                    '<input type="text" name="image_cat" class="champtext" placeholder="URL de l\'image" required>' +
                    '<label for="sous_cat">Sous-catégorie</label></br>' +
                    '<select name="sous_cat" id="sous_cat"></select>' +
                    '<input type="submit" value="Créer la catégorie" class="btn">' +
                    '</form>');

                var categories = <?php echo $categoriesJSON; ?>;
                $selectSousCat = $('#sous_cat');
                $selectSousCat.append('<option value="-1">Pas de sous-catégorie</option>');
                categories.forEach(function (categorie) {
                    $selectSousCat.append('<option value="' + categorie.id_cat + '">' + categorie.nom_cat + '</option>');
                });

            } else {
                // Sinon, masquer le formulaire de création de nouvelle catégorie
                divDroite.empty();
            }
        });

        // Ajouter un écouteur d'événement pour soumettre le formulaire de création de marque
        divDroite.on('submit', '#formMarque', function (e) {
            e.preventDefault();
            // Récupérer les données du formulaire
            var formData = $(this).serialize();
            // Effectuer une requête AJAX pour créer la nouvelle marque (ajustez l'URL et la méthode selon votre besoin)
            $.ajax({
                url: 'controleur.php?action=creerMarque',
                method: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    // Mettre à jour le select de marque avec la nouvelle option
                    var idMarque = response.match(/"id_marque":"([^"]+)"/)[1];
                    var nomMarque = response.match(/"nom_marque":"([^"]+)"/)[1];

                    // Mettre à jour le select de marque avec la nouvelle option
                    selectMarque.append('<option value="' + idMarque + '">' + nomMarque + '</option>');
                    // Masquer le formulaire de création
                    divDroite.empty();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Ajouter un écouteur d'événement pour soumettre le formulaire de création de catégorie
        divDroite.on('submit', '#formCategorie', function (e) {
            e.preventDefault();
            // Récupérer les données du formulaire
            var formData = $(this).serialize();
            // Effectuer une requête AJAX pour créer la nouvelle catégorie (ajustez l'URL et la méthode selon votre besoin)
            $.ajax({
                url: 'controleur.php?action=creerCategorie',
                method: 'POST',
                data: formData,
                success: function (response) {
                    console.log(response);
                    var idCat = response.match(/"id_cat":"([^"]+)"/)[1];
                    var nomCat = response.match(/"nom_cat":"([^"]+)"/)[1];

                    // Mettre à jour le select de catégorie avec la nouvelle option
                    selectCategorie.append('<option value="' + idCat + '">' + nomCat + '</option>');
                    // Masquer le formulaire de création
                    divDroite.empty();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>