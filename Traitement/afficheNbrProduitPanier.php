<?php 
if(isset($_COOKIE['panier'])){
    $produitsDecode = json_decode($_COOKIE['panier'], true); 
    $produits = array();
    $totalQuantite = 0;
    foreach ($produitsDecode as $unProduit) {
        $produits[] = array(
            'reference' => $unProduit['reference'],
            'nom' => $unProduit['nom'],
            'quantite' => $unProduit['quantite'],
            'point' => $unProduit['point']
        );
        $totalQuantite += $unProduit['quantite'];
    }
    echo json_encode($totalQuantite);
    die();
}
else {
    echo json_encode('0');
    die();
}
?>