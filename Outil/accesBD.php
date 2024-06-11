<?php
    class accesBD
    {
        private $hote;
        private $login;
        private $port;
        private $password; 
        private $base;
        private $conn;


        public function __construct()
        {
            //Remplacer le login et le password par les données en commentaire avant de mettre le site en ligne
            $this->hote = 'localhost';
            $this->login = "root"; //joyeuxcsqhbdcho
            //$this->port = "80";
            $this->password = ""; //278f4eGhTPAy
            $this->base = 'joyeuxcsqhbdcho';
            $this->connexion();
        }
        public function connexion()
        {
            try
            {
                $this->conn = new PDO("mysql:host=".$this->hote.";dbname=".$this->base.";port=".$this->port.";charset=utf8",$this->login,$this->password);
            }
            catch (PDOException $e){
                die ('CONNEXION <br> La connexion à la base de données a échoué.<br>'.$e.' <br/><br/> Merci de nous contacter à cette adresse "<h3>contact@joyeux-cse.fr</h3>" en nous indiquant le message d\'erreur ci-dessus.');
            }
        }
    

///
// On vérifie si le code carte et le code pin existent      
	    public function verifExistanceCarte($codeCarte,$codePin)
	    {   
			try
			{
					$codeCarte = htmlspecialchars($codeCarte); 
					$requete=$this->conn->prepare("SELECT codeCarte, codePin, statut FROM carte where statut = 1 and codeCarte like ? and codePin like ? ;");
					$requete->bindValue(1,$codeCarte);
					$requete->bindValue(2,$codePin);
                    $requete->execute();
					$result = $requete->fetch(PDO::FETCH_NUM);
					
                    if ($result)
                    {
                        return 1;
                    }
                    else {
                        echo 'ERREUR';
                        return 0;
                    }
			}
			catch(PDOException $e)
			{
				die("erreur dans la requête".$e->getMessage());
			}
	    }
///
// On récupère la description de l'entreprise associée à la carte rentrée en paramètre 
        public function infoCarteDescription($choixd)
        {
            try{
                $requete=$this->conn->prepare('SELECT distinct descriptionEntreprise FROM entreprise, carte WHERE idDeEntreprise = idEntreprise AND codeCarte like ?;');
                $requete->bindValue(1,$choixd);
                $requete->execute();
                $retour='';
                while ($row=$requete->fetch(PDO::FETCH_OBJ))
                {
                    $retour = $row->descriptionEntreprise;
                }
                return $retour;
            }
            catch(PDOException $e)
            {
               	die("erreur dans la requête".$e->getMessage());
            }
        }
///
// On récupère le nombre de point de la carte rentrée en paramètre 
        public function infoCartePoint($choixp)
        {
            try{
                $requete=$this->conn->prepare('SELECT nbrPointCarte FROM carte WHERE codePin like ?;');
                $requete->bindValue(1,$choixp);
                $requete->execute();
                $retour='';
                while ($row=$requete->fetch(PDO::FETCH_OBJ))
                {
                    $retour = $row->nbrPointCarte;
                }
                return $retour;
            }
            catch(PDOException $e)
            {
                die("erreur dans la requête".$e->getMessage());
            }
        }
///
// On récupère la totalité des produits dans la vue produit_accueil
        public function vueProduit($codePin)
        {
            try 
            {
                // MODIFICATION 
                $recupPointCarte=$this->conn->prepare('SELECT nbrPointCarte from carte where codePin like ?;');
                $recupPointCarte->bindValue(1,$codePin);
                $recupPointCarte->execute();
                $row=$recupPointCarte->fetch(PDO::FETCH_OBJ);
                $pointCarte = $row->nbrPointCarte;
                $retour='';

                if ($pointCarte <= 0) 
                {
                    $recupPointEntreprise=$this->conn->prepare('SELECT nbrPointEntreprise from entreprise inner join carte on carte.idDeEntreprise = entreprise.idEntreprise where codePin like ?;');
                    $recupPointEntreprise->bindValue(1,$codePin);
                    $recupPointEntreprise->execute();
                    $row=$recupPointEntreprise->fetch(PDO::FETCH_OBJ);
                    $pointEntreprise = $row->nbrPointEntreprise;

                    $requete = $this->conn->prepare("select nomProduit, nbrPointProduit, referenceProduit, descriptionProduit, valeurNutriProduit, urlImage, principaleImage from produit inner join lesimages on produit.idProduit = lesimages.idImage where principaleImage = 1 and produit.statutProduit = 1 and nbrPointProduit <= ".$pointEntreprise.";");//requête utilisée sur le site en ligne -> ("SELECT nomProduit, nbrPointProduit, referenceProduit, descriptionProduit, valeurNutriProduit, urlImage, principaleImage from produit_accueil, carte, entreprise where entreprise.idEntreprise = carte.idDeEntreprise and principaleImage=1 and codePin like ?;"); 
                    //non nécessaire avec cette requête -> $requete->bindValue(1,$codePin);
                    $requete->execute();
                    $retour = array();
                    $unProduit = array();
                    while ($row=$requete->fetch(PDO::FETCH_OBJ))
                    {
                        array_push($unProduit,"$row->nomProduit","$row->nbrPointProduit","$row->referenceProduit","$row->descriptionProduit","$row->valeurNutriProduit","$row->urlImage","$row->principaleImage");
                        array_push($retour,$unProduit);
                        $unProduit = array();
                    }
                }
                else {
                    $requete = $this->conn->prepare("select nomProduit, nbrPointProduit, referenceProduit, descriptionProduit, valeurNutriProduit, urlImage, principaleImage from produit inner join lesimages on lesimages.idImage = produit.idProduit where principaleImage = 1 and produit.statutProduit = 1 and nbrPointProduit <= ".$pointCarte.";"./* inner join lesImages on produit.idProduit = lesImages.idImage where principaleImage = 1*/";");//requête utilisée par le site en ligne : SELECT nomProduit, nbrPointProduit, referenceProduit, descriptionProduit, valeurNutriProduit, urlImage, principaleImage from produit_accueil, carte where principaleImage=1 and codePin like ?;"); 
                    //inutile avec la requête locale : $requete->bindValue(1,$codePin);
                    $requete->execute();
                    $retour = array();
                    $unProduit = array();
                    while ($row=$requete->fetch(PDO::FETCH_OBJ))
                    {
                        array_push($unProduit,"$row->nomProduit","$row->nbrPointProduit","$row->referenceProduit","$row->descriptionProduit","$row->valeurNutriProduit","$row->urlImage","$row->principaleImage");
                        array_push($retour,$unProduit);
                        $unProduit = array();
                    }
                }

                // $requete = $this->conn->prepare("SELECT nomProduit, nbrPointProduit, referenceProduit, descriptionProduit, valeurNutriProduit, urlImage, principaleImage from produit_accueil, carte where principaleImage=1 and nbrPointProduit <= nbrPointCarte and codePin like ?;"); 
                // $requete->bindValue(1,$codePin);
                // $requete->execute();
                // $retour = array();
                // $unProduit = array();
                // while ($row=$requete->fetch(PDO::FETCH_OBJ))
                // {
                //     array_push($unProduit,"$row->nomProduit","$row->nbrPointProduit","$row->referenceProduit","$row->descriptionProduit","$row->valeurNutriProduit","$row->urlImage","$row->principaleImage");
                //     array_push($retour,$unProduit);
                //     $unProduit = array();
                // }
                return $retour;
            }
            catch(PDOException $e)
            {
                die("erreur dans la requête<br>Vue produit".$e->getMessage());
            }
        }
///
// On récupère les informations d'un produit en fonction de sa référence
public function vueUnProduit($laRef)
{
    try 
    {
        $requete = $this->conn->prepare("select referenceProduit, nomProduit, nbrPointProduit, descriptionProduit, valeurNutriProduit, urlImage from produit inner join lesImages on lesImages.idImage = produit.idProduit where referenceProduit like ?;"); //requête utilisée en ligne : SELECT referenceProduit, nomProduit, nbrPointProduit, descriptionProduit, valeurNutriProduit, urlImage from produit_accueil where referenceProduit like ?;"); 
        $requete->bindValue(1,$laRef);
        $requete->execute();
        $retour = array();
        $unProduit = array();
        while ($row=$requete->fetch(PDO::FETCH_OBJ))
        {
            array_push($unProduit,"$row->referenceProduit","$row->nomProduit","$row->nbrPointProduit","$row->descriptionProduit","$row->valeurNutriProduit","$row->urlImage");
            array_push($retour,$unProduit);
        }
        return $retour;
        
    }
    catch(PDOException $e)
    {
        die("erreur dans la requête".$e->getMessage());
    }
}
///
// On récupère le nombre total de produit de la vue_accueil 
        public function totalVueProduit($codePin) 
        {
            try {
                    $recupPointCarte = $this->conn->prepare('SELECT nbrPointCarte FROM carte WHERE codePin LIKE ?;');
                    $recupPointCarte->bindValue(1, $codePin);
                    $recupPointCarte->execute();
                    $row = $recupPointCarte->fetch(PDO::FETCH_OBJ);
                    $pointCarte = $row->nbrPointCarte;
                    $retour = 0;

            if ($pointCarte <= 0) {
                    $requete = $this->conn->prepare('SELECT COUNT(idProduit) AS totalP FROM produit INNER JOIN lesimages ON lesimages.idImage = produit.idProduit WHERE principaleImage = 1 AND nbrPointProduit <= ? AND produit.statutProduit = 1;');
                    $requete->bindValue(1, $this->selectPointEntrepriseWhereCodePin($codePin));
            } else {
                    $requete = $this->conn->prepare('SELECT COUNT(idProduit) AS totalP FROM produit INNER JOIN lesimages ON lesimages.idImage = produit.idProduit WHERE principaleImage = 1 AND produit.nbrPointProduit <= ? AND produit.statutProduit = 1;');
                    $requete->bindValue(1, $pointCarte);
            }

                $requete->execute();
                $row = $requete->fetch(PDO::FETCH_OBJ);
                if ($row) {
                    $retour = $row->totalP;
                    }

                return $retour;
            } catch (PDOException $e) {
                die("Erreur dans la requête: " . $e->getMessage());
            }
        }


            //fonction utilie uniquement en local :
            public function selectPointEntrepriseWhereCodePin($codePin)
            {
                try
                {
                    $requete=$this->conn->prepare('select nbrPointEntreprise from entreprise inner join carte on carte.idDeEntreprise = entreprise.idEntreprise where codePin like ?');
                    $requete->bindValue(1,$codePin);
                    $requete->execute();
                    $retour = 0;
                    while ($row=$requete->fetch(PDO::FETCH_OBJ))
                    {
                        $retour = $row->nbrPointEntreprise;
                    }
                    return $retour;
                }
                catch(PDOException $e) 
                {
                    die("erreur dans la requête".$e->getMessage());
                }
            }
///
// On recherche l'URL de l'image du produit dont la référence nous a été passé en paramètre
            public function rechercheURL($reference) {
                try {
                    $requete=$this->conn->prepare('select urlImage from lesImages where referenceDeProduit like ?;'); //requête utilisée en ligne : SELECT urlImage from produit_accueil where referenceProduit like ?');
                    $requete->bindValue(1,$reference);
                    $requete->execute();
                    $retour = '';
                    while ($row=$requete->fetch(PDO::FETCH_OBJ))
                    {
                        $retour = $row->urlImage;
                    }
                    return $retour;
                }
                catch(PDOException $e) 
                {
                    die("erreur dans la requête".$e->getMessage());
                }
            }

///
// On enregistre les informations d'une commande quand la commande est validée
            public function enregistrerCommande($codePin, $panierArray, $infoClientJSON, $typeLivraison) {
                try {
                    //Création d'un objet date à la date du jour actuel 
                        $date = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
                        $dateTimeUTC = $date->format('Y-m-d H:i:s');
                    //==================================================================================
                    // Update CARTE
                    //==================================================================================
                        $carte = $this->modificationCarte($panierArray,$codePin);
                        if (!isset($carte) || !$carte) {
                            die("Erreur modification carte");
                        }
                    //==================================================================================
                    // Insert PERSONNE
                    //==================================================================================
                        $personne = $this->insertionPersonne($infoClientJSON,$typeLivraison);
                        if (!isset($personne) || !$personne) {
                            die("Erreur insertion client");
                        }
                    //==================================================================================
                    // Insert COMMANDE
                    //==================================================================================
                        $commande = $this->insertionCommande($codePin,$infoClientJSON,$typeLivraison,$dateTimeUTC);
                        if (!isset($commande) || !$commande) {
                            die("Erreur insertion commande");
                        }
                    //==================================================================================
                    // Insert CONTENIR
                    //==================================================================================
                        $contenir = $this->insertionContenir($dateTimeUTC,$panierArray,$infoClientJSON,$codePin,$typeLivraison);
                        if (!isset($contenir) || !$contenir) {
                            die("Erreur insertion contenir");
                        }
                    //==================================================================================
                    // Update PRODUIT
                    //==================================================================================
                        $produit = $this->modificationProduit($panierArray);
                        if (!isset($produit) || !$produit) {
                            die("Erreur insertion produit");
                        }
                        if ($carte && $personne && $commande && $contenir) {
                            return 'ok';
                        }       
                    
                }
                catch(PDOException $e) {
                    return 'pasok';
                    //die("Erreur dans la requête".$e->getMessage());
                }
            }
///
// Étape commande - insertion d'une personne 
            private function insertionPersonne($infoClientJSON,$typeLivraison) {
                //Récupération et décodage des infos du client en JSON
                    $infoClient = json_decode($infoClientJSON, true);
                    $nom = $infoClient['nom'];
                    $prenom = $infoClient['prenom'];
                    $adresse = $infoClient['adresse'];
                    $codePostal = $infoClient['cp'];
                    $ville = $infoClient['ville'];
                    if (!isset($infoClient['adresseComp'])) {
                        $adresseComplementaire = 'vide';
                    } else {
                        $adresseComplementaire =$infoClient['adresseComp'];
                    }
                    $email = $infoClient['email'];
                    $tel = $infoClient['tel'];
                    if (!isset($infoClient['nomEntreprise'])) {
                        $nomEntreprise = 'vide';
                    } else {
                        $nomEntreprise = $infoClient['nomEntreprise'];
                    }
                    $lieuLivraison = $typeLivraison;
                //Insertion
                    $requetePersonne=$this->conn->prepare('INSERT INTO personne(nomPersonne, prenomPersonne, adressePersonne, codePostalPersonne, villePersonne, adresseComplementPersonne, emailPersonne, telPersonne, nomEntreprisePersonne, lieuLivraisonPersonne) values (?,?,?,?,?,?,?,?,?,?);');
                    $requetePersonne->bindValue(1,$nom);
                    $requetePersonne->bindValue(2,$prenom);
                    $requetePersonne->bindValue(3,$adresse);
                    $requetePersonne->bindValue(4,$codePostal);
                    $requetePersonne->bindValue(5,$ville);
                    $requetePersonne->bindValue(6,$adresseComplementaire);
                    $requetePersonne->bindValue(7,$email);
                    $requetePersonne->bindValue(8,$tel);
                    $requetePersonne->bindValue(9,$nomEntreprise);
                    $requetePersonne->bindValue(10,$lieuLivraison);
                    $exePersonne = $requetePersonne->execute();
                //
                return $exePersonne;
            }
///
// Étape commande - modification de la carte 
            private function modificationCarte($panier,$codePin) {
                //Initialisation point total du panier 
                    $totalPointPanier=0;                   
                    foreach ($panier as $unProduit) { 
                            $totalPointPanier += (intval($unProduit->point)*$unProduit->quantite);
                    }
                //Récupération du nombre de point de la carte 
                    $recupPoint=$this->conn->prepare('SELECT nbrPointcarte from carte where codePin like ?;');
                    $recupPoint->bindValue(1,$codePin);
                    $exeRecupPoint = $recupPoint->execute();
                    $row=$recupPoint->fetch(PDO::FETCH_OBJ);
                    $pointCarte = $row->nbrPointcarte;
                //Calcul des points restants
                    $newPointCarte = $pointCarte - $totalPointPanier;
                    if ($newPointCarte <= 0) {
                        $newPointCarte = 0;
                    }
                //Update 
                    $requeteCarte=$this->conn->prepare('UPDATE carte SET nbrPointcarte = ? WHERE codePin like ?;');
                    $requeteCarte->bindValue(1,$newPointCarte);
                    $requeteCarte->bindValue(2,$codePin);
                    $exeCarte = $requeteCarte->execute();
                //
                return $exeCarte;
            }
///
// Étape commande - insertion commande 
            private function insertionCommande($codePin,$infoClientJSON,$typeLivraison,$dateTimeUTC) {
                //Récupération et décodage des infos du client en JSON
                    $infoClient = json_decode($infoClientJSON, true);
                    $nom = $infoClient['nom'];
                    $prenom = $infoClient['prenom'];
                    $email = $infoClient['email'];
                    $tel = $infoClient['tel'];
                //Récupération de l'id de la carte 
                    $recupidC=$this->conn->prepare('SELECT idCarte from carte where codePin like ?;');
                    $recupidC->bindValue(1,$codePin);
                    $exeRecupIdC = $recupidC->execute();
                    $row=$recupidC->fetch(PDO::FETCH_OBJ);
                    $idCarte = $row->idCarte;
                //Récupération de l'id de la personne 
                    $recupidPersonne=$this->conn->prepare('SELECT idPersonne from personne where nomPersonne like ? and prenomPersonne like ? and telPersonne like ? and emailPersonne like ? and lieuLivraisonPersonne like ?;');
                    $recupidPersonne->bindValue(1,$nom);
                    $recupidPersonne->bindValue(2,$prenom);
                    $recupidPersonne->bindValue(3,$tel);
                    $recupidPersonne->bindValue(4,$email);
                    $recupidPersonne->bindValue(5,$typeLivraison);
                    $exeRecupIdPersonne = $recupidPersonne->execute();
                    $row=$recupidPersonne->fetch(PDO::FETCH_OBJ);
                    $idDePersonne = $row->idPersonne;
                //Insertion 
                    $requeteCommande=$this->conn->prepare('INSERT INTO commande(dateCommande, idDeCarte, idDePersonne) values (?,?,?);');
                    $requeteCommande->bindValue(1,$dateTimeUTC);
                    $requeteCommande->bindValue(2,$idCarte);
                    $requeteCommande->bindValue(3,$idDePersonne);
                    $exeCommande = $requeteCommande->execute();
                //
                return $exeCommande;
            }
///
// Étape commande - insertion contenir (= le panier)
            private function insertionContenir($dateTimeUTC,$panier,$infoClientJSON,$codePin,$typeLivraison) {
            //Récupération et décodage des infos du client en JSON
                $infoClient = json_decode($infoClientJSON, true);
                $nom = $infoClient['nom'];
                $prenom = $infoClient['prenom'];
                $email = $infoClient['email'];
                $tel = $infoClient['tel'];
            //Récupération de l'id de la carte 
                $recupidC=$this->conn->prepare('SELECT idCarte from carte where codePin like ?;');
                $recupidC->bindValue(1,$codePin);
                $exeRecupIdC = $recupidC->execute();
                $row=$recupidC->fetch(PDO::FETCH_OBJ);
                $idCarte = $row->idCarte;
            //Récupération de l'id de la personne 
                $recupidPersonne=$this->conn->prepare('SELECT idPersonne from personne where nomPersonne like ? and prenomPersonne like ? and telPersonne like ? and emailPersonne like ? and lieuLivraisonPersonne like ?;');
                $recupidPersonne->bindValue(1,$nom);
                $recupidPersonne->bindValue(2,$prenom);
                $recupidPersonne->bindValue(3,$tel);
                $recupidPersonne->bindValue(4,$email);
                $recupidPersonne->bindValue(5,$typeLivraison);
                $exeRecupIdPersonne = $recupidPersonne->execute();
                $row=$recupidPersonne->fetch(PDO::FETCH_OBJ);
                $idDePersonne = $row->idPersonne;
                //Récupération de l'id de commande 
                $recupidCommande=$this->conn->prepare('SELECT idCommande from commande where dateCommande like ? and idDePersonne like ? and idDeCarte like ?;');
                $recupidCommande->bindValue(1,$dateTimeUTC);
                $recupidCommande->bindValue(2,$idDePersonne);
                $recupidCommande->bindValue(3,$idCarte);
                $exeRecupIdCommande = $recupidCommande->execute();
                $row=$recupidCommande->fetch(PDO::FETCH_OBJ);
                $idDeCommande = $row->idCommande;
            //Récupération de l'id produit et insertion dans la table contenir pour chaque produit
                foreach ($panier as $unProduit) {
                    //Récupération de l'id du produit actuel
                        $recupidProduit=$this->conn->prepare('SELECT idProduit from produit where referenceProduit like ? and nomProduit like ? and nbrPointProduit like ?;');
                        $recupidProduit->bindValue(1,$unProduit->reference);
                        $recupidProduit->bindValue(2,$unProduit->nom);
                        $recupidProduit->bindValue(3,$unProduit->point);
                        $exeRecupIdProduit = $recupidProduit->execute();
                        $row=$recupidProduit->fetch(PDO::FETCH_OBJ);
                        $idProduit = $row->idProduit;
                    //Insertion 
                        $requeteContenir=$this->conn->prepare('INSERT INTO contenir values (?,?,?);');
                        $requeteContenir->bindValue(1,$idDeCommande);
                        $requeteContenir->bindValue(2,$idProduit);
                        $requeteContenir->bindvalue(3,$unProduit->quantite);
                        $exeContenir = $requeteContenir->execute();
                }
                return $exeContenir;
            }
///
// Étape produit - modification du stock du produit 
            private function modificationProduit($panier) {
                //Parcours chaque produit du panier pour modifier son stock total 
                foreach ($panier as $unProduit) {
                    //Récupération de l'id du produit actuel
                        $recupidProduit=$this->conn->prepare('SELECT idProduit from produit where referenceProduit like ? and nomProduit like ? and nbrPointProduit like ?;');
                        $recupidProduit->bindValue(1,$unProduit->reference);
                        $recupidProduit->bindValue(2,$unProduit->nom);
                        $recupidProduit->bindValue(3,$unProduit->point);
                        $exeRecupIdProduit = $recupidProduit->execute();
                        $row=$recupidProduit->fetch(PDO::FETCH_OBJ);
                        $idProduit = $row->idProduit;
                    //Récupération de la quantité du produit 
                        $recupstockProduit=$this->conn->prepare('SELECT stockProduit from produit where idProduit like ?;');
                        $recupstockProduit->bindValue(1,$idProduit);
                        $exeRecupstockProduit = $recupstockProduit->execute();
                        $row=$recupstockProduit->fetch(PDO::FETCH_OBJ);
                        $stockProduit = $row->stockProduit;
                    //Calcul du nouveau stock 
                        $newStock = $stockProduit - $unProduit->quantite;
                    //Modification du stock du produit actuel 
                        $requeteProduit=$this->conn->prepare('UPDATE produit SET stockProduit = ? WHERE idProduit like ?;');
                        $requeteProduit->bindValue(1,$newStock);
                        $requeteProduit->bindValue(2,$idProduit);
                        $exeProduit = $requeteProduit->execute();
                }
                return $exeProduit;
            }
///
}
?>