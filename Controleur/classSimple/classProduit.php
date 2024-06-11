<?php 
    Class Produit{
        private $reference; 
        private $nom;
        private $point;
        private $quantite; 

        public function __construct($uneRef, $unNom, $uneQuantite, $numPoint)
        {
            $this->reference = $uneRef;
            $this->nom = $unNom;
            $this->quantite = $uneQuantite;
            $this->point = $numPoint;
        }

        public function afficheProduit()
        {
            echo '<br>'.'Référence : '.$this->getRefProduit();
            echo '<br>'.'Nom : '.$this->getNomProduit();
            echo '<br>'.'Nombre de point : '.$this->getNbrPointProduit();
            echo '<br>'.'Quantité : '.$this->getQuantiteProduit().'<br><br>';
        }

        // Les guetteurs
        public function getRefProduit() {
            return $this->reference;
        }
        public function getNomProduit(){
            return $this->nom;
        }
        public function getNbrPointProduit(){
            return $this->point;
        }
        public function getQuantiteProduit(){
            return $this->quantite;
        }

        // Les setteurs
        public function setRefProduit($newReference) {
            $this->reference = $newReference;
        }
        public function setNomProduit($newNom) {
            $this->nom = $newNom;
        }
        public function setNbrPointProduit($newPoint) {
            $this->point = $newPoint;
        }
        public function setQuantiteProduit($newQuantite) {
            $this->quantite = $newQuantite;
        }

    }
?>