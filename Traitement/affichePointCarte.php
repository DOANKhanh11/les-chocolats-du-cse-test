<?php 
session_start();
if(isset($_SESSION['nbrPointCarte']) && isset($_COOKIE['panier']) && isset($_GET['action'])){
    $pointCarte = intval($_SESSION['nbrPointCarte']); 
    $action = $_GET['action'];
    $totalPointPanier = 0;
    $produitsDecode = json_decode($_COOKIE['panier'], true);
    $produits = array();


    foreach ($produitsDecode as $unProduit) {
        $produits[] = array(
            'reference' => $unProduit['reference'],
            'nom' => $unProduit['nom'],
            'quantite' => $unProduit['quantite'],
            'point' => $unProduit['point']
        );
        $totalPointPanier += ($unProduit['point']*$unProduit['quantite']);
    }

    if ($action === 'add') {
        $pointRetire = $pointCarte - $totalPointPanier;
        $pointCarteApres = $pointCarte + $pointRetire;
    }
    elseif ($action === 'delete') {
        $pointCarteApres = $pointCarte - $totalPointPanier;
        if ($pointCarteApres < 0) {
            $pointCarteApres = 0;
        }
    }
    elseif ($action === 'nothing') {
        $pointCarteApres = $pointCarte;
    }
    
    echo json_encode($pointCarteApres);
    die();
}
else {
    echo json_encode('X');
    die();
}
?>