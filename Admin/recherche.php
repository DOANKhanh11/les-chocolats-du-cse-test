<?php 
    //Récupérer la valeur de recherche depuis la requête GET 
    $searchTerm = $_GET['search'];
    $type = $_GET['type'];

    // Connexion à la BD 
    include_once('accesBDA.php');
    $maBDA = new accesBDA();

    // Appel à la requête SQL
    if ($type=='produit') {
        $response = $maBDA->rechercheInfoProduit($searchTerm);
    }
    elseif ($type=='carte') {
        $response = $maBDA->rechercheInfoCarte($searchTerm);
    }
    elseif ($type=='entreprise') {
        $response = $maBDA->rechercheInfoEntreprise($searchTerm);
    }
    elseif ($type=='fournisseur') {
        $response = $maBDA->rechercheInfoFournisseur($searchTerm);
    }
    elseif ($type=='commande') {
        $response = $maBDA->rechercheInfoCommande($searchTerm);
    }

    // Renvoie de la réponse 
    echo json_encode($response);
?>