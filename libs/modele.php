<?php

include_once "libs/maLibSQL.pdo.php";

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre site web.
*/


/********* fonctions pour utiliser la base de données *********/


/* Vérifie l'identité d'un utilisateur dans la base de données
 * Paramètres :
 * - $pseudo : string - Le pseudo de l'utilisateur
 * - $mot_de_passe : string - Le mot de passe de l'utilisateur
 * Retour :  int|string - L'ID de l'utilisateur si succès, sinon false */
function verifUserBdd($pseudo, $mdp)
{
    $SQL = "SELECT id_user FROM users WHERE mail='$pseudo' OR num_telephone ='$pseudo' AND passwd='$mdp'";
    return SQLGetChamp($SQL);
}

function creer_compte($nom, $prenom, $passe, $num, $mail)
{
    //on hash le mdp
    $passe = password_hash($passe, PASSWORD_DEFAULT);
    //on insère les données dans la base de données
    $sql = "INSERT INTO users (nom, prenom,mail,num_telephone,points_fidelite, passwd, id_role)
		  VALUES ('$nom','$prenom','$mail','$num',0, '$passe',2)";
    SQLInsert($sql);
}

function recupRole($id)
{
    $sql = "SELECT id_role FROM users WHERE id_user = '$id'";
    return SQLGetChamp($sql);
}

function listeEmployes()
{
    $sql = "SELECT id_user, nom, prenom, adresse,mail, num_telephone, points_fidelite, roles.nom_role,users.id_role FROM users JOIN roles ON users.id_role = roles.id_role
    WHERE users.id_role =1 ";
    return parcoursRs(SQLSelect($sql));
}

function creer_produit($designation, $image, $num_serie, $prix, $description, $datasheet, $id_marque, $id_categorie)
{
    $sql = "INSERT INTO produit (designation, image_prod, num_serie, prix_unitaire, descriptif_produit, datasheet, id_marque, id_cat)
          VALUES ('$designation','$image','$num_serie','$prix','$description','$datasheet','$id_marque','$id_categorie')";
    return SQLInsert($sql);
}
function creer_stock($stock, $id)
{
    $sql = "INSERT INTO stock (quantite, quantite_min, id_produit) VALUES ('$stock',0,'$id')";
    return SQLInsert($sql);
}

function listeCategories()
{
    $sql = "SELECT id_cat, nom_cat, descriptif_cat,image_cat,sous_cat FROM categorie";
    return parcoursRs(SQLSelect($sql));
}

function listeMarques()
{
    $sql = "SELECT id_marque, nom_marque, origine,informations FROM marque";
    return parcoursRs(SQLSelect($sql));
}


function getProduitsRecherche($searchData)
{
    $produits = getProduits();
    $closestProduct = null;
    $closestDistance = PHP_INT_MAX;

    // Recherche du produit le plus proche en termes de Levenshtein
    foreach ($produits as $produit) {
        $distance = levenshtein($searchData, $produit['designation']);

        if ($distance < $closestDistance) {
            $closestProduct = $produit;
            $closestDistance = $distance;
        }
    }

    // Utilisation de Soundex pour rechercher des termes phonétiquement similaires
    $soundexSearchData = soundex($searchData);

    // Construction des requêtes SQL
    $sql1 = "SELECT id_produit, designation, image_prod, prix_unitaire FROM produit 
            WHERE 
            designation LIKE '%" . $searchData . "%'
            OR num_serie LIKE '%" . $searchData . "%'
            OR descriptif_produit LIKE '%" . $searchData . "%'";

    $sql2 = "SELECT id_produit, designation, image_prod, prix_unitaire FROM produit 
            WHERE 
            designation LIKE '%" . $closestProduct['designation'] . "%'
            OR num_serie LIKE '%" . $closestProduct['designation'] . "%'
            OR descriptif_produit LIKE '%" . $closestProduct['designation'] . "%'";

    $sql3 = "SELECT id_produit, designation, image_prod, prix_unitaire FROM produit 
            WHERE 
            SOUNDEX(num_serie) LIKE '" . $soundexSearchData . "' 
            OR SOUNDEX(designation) LIKE '" . $soundexSearchData . "' 
            OR SOUNDEX(descriptif_produit) LIKE '" . $soundexSearchData . "'";

    $sql4 = "SELECT id_produit, designation, image_prod, prix_unitaire FROM produit 
            WHERE 
            SOUNDEX(num_serie) LIKE SOUNDEX('" . $closestProduct['designation'] . "') 
            OR SOUNDEX(designation) LIKE SOUNDEX('" . $closestProduct['designation'] . "') 
            OR SOUNDEX(descriptif_produit) LIKE SOUNDEX('" . $closestProduct['designation'] . "')";

    // Exécution des requêtes SQL et parcours des résultats
    $result1 = parcoursRs(SQLSelect($sql1));
    $result2 = parcoursRs(SQLSelect($sql2));
    $result3 = parcoursRs(SQLSelect($sql3));
    $result4 = parcoursRs(SQLSelect($sql4));

    // Filtrage des résultats pour éviter les doublons
    $filteredResult2 = array_filter($result2, function ($item) use ($result1) {
        return !in_array($item, $result1);
    });

    $filteredResult3 = array_filter($result3, function ($item) use ($result1, $filteredResult2) {
        return !in_array($item, $result1) && !in_array($item, $filteredResult2);
    });

    $filteredResult4 = array_filter($result4, function ($item) use ($result1, $filteredResult2, $filteredResult3) {
        return !in_array($item, $result1) && !in_array($item, $filteredResult2) && !in_array($item, $filteredResult3);
    });

    // Fusionner et retourner les résultats
    // Retourner les résultats et true si la sql1 a retourné des résultats
    if (!empty ($result1)) {
        return array_merge([1], $result1, $filteredResult2, $filteredResult3, $filteredResult4);
    }
    return array_merge($result1, $filteredResult2, $filteredResult3, $filteredResult4);
}


function creer_marque($nom, $origine, $infos)
{
    $sql = "INSERT INTO marque (nom_marque, origine, informations)
          VALUES ('$nom','$origine','$infos')";
    return SQLInsert($sql);

}

function creer_categorie($nom, $desc, $image, $sous_cat)
{
    $sql = "INSERT INTO categorie (nom_cat, descriptif_cat, image_cat, sous_cat)
          VALUES ('$nom','$desc','$image','$sous_cat')";
    return SQLInsert($sql);
}

function creer_categorieMere($nom, $desc, $image)
{
    $sql = "INSERT INTO categorie (nom_cat, descriptif_cat, image_cat)
          VALUES ('$nom','$desc','$image')";
    return SQLInsert($sql);
}

function listeProduits()
{
    $sql = "SELECT id_produit, designation, image_prod, num_serie, prix_unitaire,promotion,descriptif_produit,nom_marque
    FROM produit JOIN marque ON produit.id_marque = marque.id_marque";
    return parcoursRs(SQLSelect($sql));
}

function supprimer_stock($id)
{
    $sql = "DELETE FROM stock WHERE id_produit = '$id'";
    SQLDelete($sql);
}
function stockProduit($id)
{
    $sql = "SELECT quantite FROM stock WHERE id_produit = '$id'";
    return SQLGetChamp($sql);
}

function modifierProduit($id, $colonne, $valeur)
{
    $sql = "UPDATE produit SET $colonne = '$valeur' WHERE id_produit = '$id'";
    SQLUpdate($sql);
}

function modifierStock($id, $valeur)
{
    $sql = "UPDATE stock SET quantite = '$valeur' WHERE id_produit = '$id'";
    SQLUpdate($sql);
}

function stockInferieurMinime()
{
    $sql = "SELECT id_produit, designation, quantite, quantite_min FROM stock JOIN produit ON stock.id_produit = produit.id_produit WHERE quantite < quantite_min";
    return parcoursRs(SQLSelect($sql));
}
/* Vérifie si un num existe dans la base de données
 * Paramètres :
 * - $pseudo : string - Le pseudo à vérifier
 * Retour :  string - Le pseudo si trouvé, sinon false */
function verifnum($num)
{
    $sql = "SELECT id_user
		  FROM users
		  WHERE num_telephone = '$num'";
    return SQLGetChamp($sql);
}

function supprimer_produit($id)
{
    $sql = "DELETE FROM produit WHERE id_produit = '$id'";
    SQLDelete($sql);
}



/* Valide une adresse e-mail
 * Paramètres :
 * - $email : string - L'adresse e-mail à valider
 * Retour : bool - true si l'adresse est valide, sinon false */
function validateMail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function verifMdp($mdp)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', $mdp);

}

// fonction pour ajouter des produits aux favoris

function ajouterFavoris($idProduit, $idUser)
{
    $sql = "INSERT INTO favoris (id_user, id_produit)
    VALUES ($idUser, $idProduit)";
}

// HOMEPAGE


function getProduits()
{
    $sql = "SELECT id_produit, designation, image_prod, prix_unitaire FROM produit";
    $result = SQLSelect($sql);
    return parcoursRs($result); // Utilisez la fonction parcoursRs pour convertir l'objet PDOStatement en tableau associatif
}

// pagnination début 
function getProduitsPagines($limit = 24, $offset = 0)
{
    $sql = "SELECT id_produit, designation, image_prod, prix_unitaire FROM produit LIMIT $limit OFFSET $offset";
    return parcoursRs(SQLSelect($sql));
}

function getTotalProduits()
{
    $sql = "SELECT COUNT(*) as total FROM produit";
    $result = SQLGetChamp($sql);
    return $result;
}



function getTotalProduitsBySousCat($idSousCategorie)
{
    $sql = "SELECT COUNT(*) as total FROM produit WHERE id_cat = '$idSousCategorie'";
    return SQLGetChamp($sql);
}


function getProduitsBySousCatPaginated($idSousCategorie, $limit, $offset)
{
    $sql = "SELECT * FROM produit WHERE id_cat = '$idSousCategorie' LIMIT $offset, $limit";
    $res = SQLSelect($sql);
    return parcoursRs($res);
}


// pagination fin

function getQuantite($idProduit)
{
    $sql = "SELECT quantite FROM stock WHERE id_produit = '$idProduit'";
    $result = SQLSelect($sql);
    return getQuantiteFromResult($result); // Utilisez une fonction dédiée pour extraire la quantité du résultat
}

function getQuantiteMin($idProduit)
{
    $sql = "SELECT quantite_min FROM stock WHERE id_produit = '$idProduit'";
    $result = SQLSelect($sql);
    return getQuantiteMinFromResult($result); // Utilisez une fonction dédiée pour extraire la quantité minimale du résultat
}

function getQuantiteFromResult($result)
{
    if ($result && $result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['quantite'];
    } else {
        return 0; // ou une valeur par défaut, selon votre logique
    }
}
function getQuantiteMinFromResult($result)
{
    if ($result && $result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['quantite_min'];
    } else {
        return 0; // ou une valeur par défaut, selon votre logique
    }
}

function getCategorieMere()
{
    $sql = "SELECT id_cat, nom_cat, descriptif_cat, image_cat FROM categorie WHERE sous_cat IS NULL";
    $result = SQLSelect($sql);
    return parcoursRs($result);
}

function getCategorieMereNom($idCategorie)
{
    $sql = "SELECT nom_cat FROM categorie WHERE id_cat = '$idCategorie'";
    $result = SQLSelect($sql);
    return parcoursRs($result);
}

function getCategorieMereImage($idCategorie)
{
    $sql = "SELECT image_cat FROM categorie WHERE id_cat = '$idCategorie'";
    $result = SQLSelect($sql);
    return parcoursRs($result);
}

function getSousCategorie($idCategorie)
{
    $sql = "SELECT id_cat, nom_cat, descriptif_cat, image_cat FROM categorie WHERE sous_cat = '$idCategorie'";
    $result = SQLSelect($sql);
    return parcoursRs($result);
}

function getProduitById($idProduit)
{
    $sql = "SELECT designation, image_prod, prix_unitaire, num_serie, descriptif_produit, datasheet, id_cat, id_marque, promotion FROM produit WHERE id_produit = '$idProduit'";
    $result = SQLSelect($sql);
    return parcoursRs($result);
}

function getProduitByCat($idCategorie)
{
    $sql = "SELECT id_produit, designation, image_prod FROM produit WHERE id_cat = '$idCategorie' ";
    $result = SQLSelect($sql);
    return parcoursRs($result);
}


function infoUser($id)
{
    $sql = "SELECT nom, prenom, adresse,mail, num_telephone, points_fidelite, roles.nom_role,users.id_role FROM users JOIN roles ON users.id_role = roles.id_role
    WHERE id_user = '$id'";
    return parcoursRs(SQLSelect($sql));
}

function modifier_user($id, $nom, $prenom, $adresse, $mail, $num, $points_fidelite, $mdp)
{
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET nom = '$nom', prenom = '$prenom', adresse = '$adresse', mail = '$mail', num_telephone = '$num', points_fidelite='$points_fidelite', passwd='$mdp' WHERE id_user = '$id'";
    SQLUpdate($sql);
}
function creer_employe($nom, $prenom, $adresse, $mail, $num, $points, $mdp)
{
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (nom, prenom,adresse,mail,num_telephone,points_fidelite, passwd, id_role)
          VALUES ('$nom','$prenom','$adresse','$mail','$num','$points', '$mdp',1)";
    SQLInsert($sql);
}

// fidelite


function listeClients()
{
    $sql = "SELECT id_user, nom, prenom, adresse,mail, num_telephone, points_fidelite, roles.nom_role,users.id_role FROM users JOIN roles ON users.id_role = roles.id_role
    WHERE users.id_role =2 ";
    return parcoursRs(SQLSelect($sql));
}

function modifierFidelite($id, $valeur)
{
    $sql = "UPDATE users SET points_fidelite = '$valeur' WHERE id_user = '$id'";
    SQLUpdate($sql);
}

function getFidelite($id)
{
    $sql = "SELECT points_fidelite FROM users WHERE id_user = '$id'";
    return SQLGetChamp($sql);
}

// compte client 

function modifierNom($id, $valeur)
{
    $sql = "UPDATE users SET nom = '$valeur' WHERE id_user = '$id'";
    SQLUpdate($sql);
}

function modifierPrenom($id, $valeur)
{
    $sql = "UPDATE users SET prenom = '$valeur' WHERE id_user = '$id'";
    SQLUpdate($sql);
}

function modifierMail($id, $valeur)
{
    $sql = "UPDATE users SET mail = '$valeur' WHERE id_user = '$id'";
    SQLUpdate($sql);
}

function modifierNum($id, $valeur)
{
    $sql = "UPDATE users SET num_telephone = '$valeur' WHERE id_user = '$id'";
    SQLUpdate($sql);
}

function modifierAdresse($id, $valeur)
{
    $sql = "UPDATE users SET adresse = '$valeur' WHERE id_user = '$id'";
    SQLUpdate($sql);
}


function supprimer_employe($id_user)
{
    $sql = "DELETE FROM users WHERE id_user = '$id_user'";
    SQLDelete($sql);
}

function stockInferieurMinim()
{
    $sql = "SELECT quantite, quantite_min, id_produit FROM stock";
    return parcoursRs(SQLSelect($sql));
}

?>