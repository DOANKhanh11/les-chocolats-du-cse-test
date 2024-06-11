<?php 
if(isset($_COOKIE['panier'])){
	$produits = json_decode($_COOKIE['panier'], true);
	echo json_encode($produits);
}
?>