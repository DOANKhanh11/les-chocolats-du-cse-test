<?php
    class accesBDA
    {
        private $hote;
        private $login;
        private $password; 
        private $base;
        private $conn;

        public function __construct()
        {
            /*$this->hote = 'joyeuxcsqhbdcho.mysql.db';
            $this->login = "joyeuxcsqhbdcho";
            $this->password = "278f4eGhTPAy";
            $this->base = 'joyeuxcsqhbdcho';
            $this->connexion();*/
            $this->hote = 'localhost';
            $this->login = "root"; //joyeuxcsqhbdcho
            //$this->port = "8889";
            $this->password = ""; //278f4eGhTPAy
            $this->base = 'joyeuxcsqhbdcho';
            $this->connexion();
        }

        public function connexion()
        {
            try
            {
                $this->conn = new PDO("mysql:host=".$this->hote.";dbname=".$this->base.";charset=utf8",$this->login,$this->password);
            }
            catch (PDOException $e){
                die ('La connexion à la base de données a échoué. <br/><br/> Merci de nous contacter à cette adresse "<h3>contact@joyeux-cse.fr</h3>" en nous indiquant le message d\'erreur ci-dessus.');
            }
        }

        

///
// On vérifie si le code carte et le code pin existent      
	    public function verifCle($cle)
	    {   
			try
			{
					$cleMD5 = md5($cle); 
					$requete=$this->conn->prepare("SELECT * FROM compteadmin where cleConnexion like ?;");
					$requete->bindValue(1,$cleMD5);
                    $requete->execute();
					$result = $requete->fetch(PDO::FETCH_NUM);
					
                    if ($result)
                    {
                        return 'accepte';
                    }
                    else {
                        return 'refuse';
                    }
			}
			catch(PDOException $e)
			{
				die("erreur dans la requête ".$e->getMessage());
			}
	    }
///
/// ============================================================
/// ======================== PRODUITS ============================
/// ============================================================
// On recherche un élément dans la table de produit
        public function rechercheInfoProduit($info) {
            try {
                $requete = $this->conn->prepare("SELECT produit.*, nomFournisseur FROM produit INNER JOIN fournisseur ON produit.idDeFournisseur = fournisseur.idFournisseur WHERE referenceProduit LIKE ? OR nomProduit LIKE ? OR nbrPointProduit LIKE ? OR nomFournisseur LIKE ?;");
                $requete->bindValue(1,'%'.$info.'%');
                $requete->bindValue(2,'%'.$info.'%');
                $requete->bindValue(3,$info);
                $requete->bindValue(4,'%'.$info.'%');
                $requete->execute();
                $retour = array();
                $unProduit = array();
                while ($row=$requete->fetch(PDO::FETCH_OBJ))
                {
                    $unProduit = new stdClass();
                    $unProduit->type = 'produit';
                    $unProduit->id = $row->idProduit;
                    $unProduit->reference = $row->referenceProduit;
                    $unProduit->nom = $row->nomProduit;
                    $unProduit->stock = $row->stockProduit;
                    $unProduit->statut = $row->statutProduit;
                    $unProduit->point = $row->nbrPointProduit;
                    $unProduit->fournisseur =  $row->nomFournisseur;
                    array_push($retour, $unProduit);
                }
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }

        }
/// 
// Nombre total de produits (actif et inactif) 
        public function calculTotalProduits() {
            try {
                $requete = $this->conn->prepare("SELECT count(idProduit) AS totalP FROM produit;");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalP;
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de tous les produits actifs 
        public function calculTotalProduitsActifs() {
            try {
                $requete = $this->conn->prepare("SELECT count(idProduit) AS totalPA FROM produit where statutProduit like '1';");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalPA;
                return $retour;

            }catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de tous les produits inactifs 
        public function calculTotalProduitsInactifs() {
            try {
                $requete = $this->conn->prepare("SELECT count(idProduit) AS totalPI FROM produit where statutProduit like '0';");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalPI;
                return $retour;

            }catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de tous les produits ACTIF qui ont le STOCK à 0
        public function calculTotalProduitsActifsEtStock() {
            try {
                $requete = $this->conn->prepare("SELECT count(idProduit) AS totalPAS FROM produit where statutProduit like '1' and stockProduit < 10;");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalPAS;
                return $retour;

            }catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
/// ============================================================
/// ======================== CARTES ============================
/// ============================================================
// On recherche un élément dans la table de carte 
        public function rechercheInfoCarte($info) {
            try {
                $requete = $this->conn->prepare("SELECT carte.*, nomEntreprise FROM carte INNER JOIN entreprise ON carte.idDeEntreprise = entreprise.idEntreprise WHERE codeCarte LIKE ? OR codePin LIKE ? OR nbrPointcarte LIKE ? OR nomEntreprise LIKE ? OR nbrPointEntreprise LIKE ?;");
                $requete->bindValue(1,'%'.$info.'%');
                $requete->bindValue(2,'%'.$info.'%');
                $requete->bindValue(3,$info);
                $requete->bindValue(4,'%'.$info.'%');
                $requete->bindValue(5,$info);
                $requete->execute();
                $retour = array();
                $uneCarte = array();
                while ($row=$requete->fetch(PDO::FETCH_OBJ))
                {
                    $uneCarte = new stdClass();
                    $uneCarte->type = 'carte';
                    $uneCarte->id = $row->idCarte;
                    $uneCarte->codeCarte = $row->codeCarte;
                    $uneCarte->codePin = $row->codePin;
                    $uneCarte->point = $row->nbrPointcarte;
                    $uneCarte->statut = $row->statut;
                    $uneCarte->entreprise =  $row->nomEntreprise;
                    array_push($retour, $uneCarte);
                }
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de cartes (actif et inactif) 
        public function calculTotalCartes() {
            try {
                $requete = $this->conn->prepare("SELECT count(idCarte) AS totalC FROM carte;");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalC;
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de tous les cartes actifs 
        public function calculTotalCartesActifs() {
            try {
                $requete = $this->conn->prepare("SELECT count(idCarte) AS totalCA FROM carte where statut = 1;");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalCA;
                return $retour;

            }catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de tous les cartes inactifs 
        public function calculTotalCartesInactifs() {
            try {
                $requete = $this->conn->prepare("SELECT count(idCarte) AS totalCI FROM carte where statut = 0;");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalCI;
                return $retour;

            }catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
/// ============================================================
/// ===================== ENTREPRISES ==========================
/// ============================================================

// On recherche un élément dans la table de entreprise 
        public function rechercheInfoEntreprise($info) {
            try {
                $requete = $this->conn->prepare("SELECT * FROM entreprise WHERE nomEntreprise LIKE ? OR nbrPointEntreprise LIKE ? OR statutEntreprise LIKE ?;");
                $requete->bindValue(1,'%'.$info.'%');
                $requete->bindValue(2,$info);
                $requete->bindValue(3,$info);
                $requete->execute();
                $retour = array();
                $uneEntreprise = array();
                while ($row=$requete->fetch(PDO::FETCH_OBJ))
                {
                    $uneEntreprise = new stdClass();
                    $uneEntreprise->type = 'entreprise';
                    $uneEntreprise->id = $row->idEntreprise;
                    $uneEntreprise->dateCrea = $row->dateCreationEntreprise;
                    $uneEntreprise->nom = $row->nomEntreprise;
                    $uneEntreprise->statut = $row->statutEntreprise;
                    $uneEntreprise->point = $row->nbrPointEntreprise;
                    array_push($retour, $uneEntreprise);
                }
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de Entreprises (actif et inactif) 
        public function calculTotalEntreprises() {
            try {
                $requete = $this->conn->prepare("SELECT count(idEntreprise) AS totalE FROM entreprise;");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalE;
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de tous les Entreprises actifs 
        public function calculTotalEntreprisesActifs() {
            try {
                $requete = $this->conn->prepare("SELECT count(idEntreprise) AS totalEA FROM entreprise where statutEntreprise like 'actif';");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalEA;
                return $retour;

            }catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de tous les Entreprises inactifs 
        public function calculTotalEntreprisesInactifs() {
            try {
                $requete = $this->conn->prepare("SELECT count(idEntreprise) AS totalEI FROM entreprise where statutEntreprise like 'inactif';");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalEI;
                return $retour;

            }catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
/// ============================================================
/// ==================== FOURNISSEURS ==========================
/// ============================================================

// On recherche un élément dans la table de fournisseur 
        public function rechercheInfoFournisseur($info) {
            try {
                $requete = $this->conn->prepare("SELECT * FROM fournisseur WHERE nomFournisseur LIKE ? OR mailFournisseur LIKE ?;");
                $requete->bindValue(1,'%'.$info.'%');
                $requete->bindValue(2,'%'.$info.'%');
                $requete->execute();
                $retour = array();
                $unFournisseur = array();
                while ($row=$requete->fetch(PDO::FETCH_OBJ))
                {
                    $unFournisseur = new stdClass();
                    $unFournisseur->type = 'fournisseur';
                    $unFournisseur->id = $row->idFournisseur;
                    $unFournisseur->nom = $row->nomFournisseur;
                    $unFournisseur->dateCrea = $row->dateCreationFournisseur;
                    $unFournisseur->mail = $row->mailFournisseur;
                    $totalProduitFournisseur = $this->totalProduitsFournisseur($row->idFournisseur);
                    $unFournisseur->nbrProduitFournis = $totalProduitFournisseur;
                    array_push($retour, $unFournisseur);
                }
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de Fournisseurs (actif et inactif) 
        public function calculTotalFournisseurs() {
            try {
                $requete = $this->conn->prepare("SELECT count(idFournisseur) AS totalF FROM fournisseur;");
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalF;
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de produit fournis pour un Fournisseur 
        public function totalProduitsFournisseur($id) {
            try {
                $requete = $this->conn->prepare("SELECT count(idProduit) AS totalPF FROM produit WHERE produit.idDeFournisseur like ?;");
                $requete->bindValue(1, $id);
                $requete->execute();
                $retour = 0;
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalPF;
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
/// ============================================================
/// ====================== COMMANDES ===========================
/// ============================================================

// On recherche un élément dans la table de commande 
        public function rechercheInfoCommande($info) {
            try {
                $requete = $this->conn->prepare("SELECT distinct(idCommande), dateCommande, quantite, nomEntreprise, codePin, codeCarte, idProduit, referenceProduit, nomProduit, nomPersonne, prenomPersonne 
                        FROM carte INNER JOIN entreprise ON carte.idDeEntreprise = entreprise.idEntreprise 
                        INNER JOIN commande ON carte.idCarte = commande.idDeCarte 
                        INNER JOIN personne ON commande.idDePersonne = personne.idPersonne 
                        INNER JOIN contenir ON commande.idCommande = contenir.idDeCommande 
                        INNER JOIN produit ON contenir.idDeProduit = produit.idProduit
                        WHERE  entreprise.nomEntreprise LIKE ? OR carte.codePin LIKE ? OR carte.codeCarte LIKE ? OR produit.referenceProduit LIKE ? OR produit.nomProduit LIKE ? OR personne.nomPersonne LIKE ? OR personne.prenomPersonne LIKE ? OR datecommande LIKE ?;");
                $requete->bindValue(1,'%'.$info.'%');
                $requete->bindValue(2,'%'.$info.'%');
                $requete->bindValue(3,'%'.$info.'%');
                $requete->bindValue(4,'%'.$info.'%');
                $requete->bindValue(5,'%'.$info.'%');
                $requete->bindValue(6,'%'.$info.'%');
                $requete->bindValue(7,'%'.$info.'%');
                $requete->bindValue(8,date("Y-m-d", strtotime($info)));
                $requete->execute();
                $retour = array();
                $uneCommande = array();
                $tableauPanier = array();
                while ($row=$requete->fetch(PDO::FETCH_OBJ))
                {
                    $uneCommande = new stdClass();
                    $tableauPanier = new stdClass();
                    $uneCommande->type = 'commande';
                    $uneCommande->id = $row->idCommande;
                    $uneCommande->dateCommande = $row->dateCommande;
                    $uneCommande->nomEntreprise = $row->nomEntreprise;
                    $uneCommande->codePin = $row->codePin;
                    $uneCommande->codeCarte = $row->codeCarte;
                    // Tableau contenant le panier lors de la commande 
                    $tableauPanier->idProduit = $row->idProduit;
                    $tableauPanier->referenceProduit = $row->referenceProduit;
                    $tableauPanier->nomProduit = $row->nomProduit;
                    $tableauPanier->quantite = $row->quantite;
                    $uneCommande->tableauPanier = $tableauPanier;
                    // Fin du tableau
                    $uneCommande->nomPersonne = $row->nomPersonne;
                    $uneCommande->prenomPersonne = $row->prenomPersonne;
                    array_push($retour, $uneCommande);
                }
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
// Nombre total de commandes passées 
        public function calculTotalCommandes() {
            try {
                $retour = 0;
                $requete = $this->conn->prepare("SELECT count(idCommande) AS totalCommande FROM commande;");
                $requete->execute();
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalCommande;
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
// Nombre total de commandes passées 
        public function calculTotalCommandesParMois() {
            try {
                //Création d'un objet date à la date du jour actuel 
                $date = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
                $dateTimeUTC = $date->format('m');
                $retour = 0;
                $requete = $this->conn->prepare("SELECT count(idCommande) AS totalCommande FROM commande WHERE MONTH(dateCommande) = ?;");
                $requete->bindValue(1,$dateTimeUTC);
                $requete->execute();
                $row = $requete->fetch(PDO::FETCH_OBJ);
                $retour = $row->totalCommande;
                if ($retour==NULL) {
                    $retour=0;
                }
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
///
///
///
// Récupérer les informations en fonction de l'élément passé en paramètre 
        public function recupererInfo($table, $id, $reference) {
            try {
                if ($table=='produit' || $table=='carte' || $table=='entreprise' || $table=='fournisseur') {
                    $cas = htmlspecialchars($table);
                    $retour = [];
                    switch($cas) {
                        case 'produit':
                            $requete = $this->conn->prepare("SELECT referenceProduit, dateCreationProduit, nomProduit, stockProduit, statutProduit, nbrPointProduit, descriptionProduit, valeurNutriProduit, idDeFournisseur FROM produit WHERE idProduit like ? and referenceProduit like ?;");
                            $requete->bindValue(1,$id);
                            $requete->bindValue(2,$reference);
                            $requete->execute();
                            while ($row=$requete->fetch(PDO::FETCH_OBJ))
                            {
                                array_push($retour,$row->referenceProduit);
                                array_push($retour,$row->dateCreationProduit);
                                array_push($retour,$row->nomProduit);
                                array_push($retour,$row->stockProduit);
                                array_push($retour,$row->statutProduit);
                                array_push($retour,$row->nbrPointProduit);
                                array_push($retour,$row->descriptionProduit);
                                array_push($retour,$row->valeurNutriProduit);
                                array_push($retour,$row->idDeFournisseur);
                            }
                            break;
                        case 'carte':
                            $requete = $this->conn->prepare("SELECT codeCarte, codePin, nbrPointcarte, statut FROM carte WHERE idCarte like ? and codePin like ?;");
                            $requete->bindValue(1,$id);
                            $requete->bindValue(2,$reference);
                            $requete->execute();
                            while ($row=$requete->fetch(PDO::FETCH_OBJ))
                            {
                                array_push($retour,$row->codeCarte);
                                array_push($retour,$row->codePin);
                                array_push($retour,$row->nbrPointcarte);
                                array_push($retour,$row->statut);
                            }
                            break;
                        case 'entreprise':
                            $requete = $this->conn->prepare("SELECT dateCreationEntreprise, nomEntreprise, descriptionEntreprise, statutEntreprise, nbrPointEntreprise  FROM entreprise WHERE idEntreprise like ?;");
                            $requete->bindValue(1,$id);
                            $requete->execute();
                            while ($row=$requete->fetch(PDO::FETCH_OBJ))
                            {
                                array_push($retour,$row->dateCreationEntreprise);
                                array_push($retour,$row->nomEntreprise);
                                array_push($retour,$row->descriptionEntreprise);
                                array_push($retour,$row->statutEntreprise);
                                array_push($retour,$row->nbrPointEntreprise);
                            }
                            break;
                        case 'fournisseur':
                            $requete = $this->conn->prepare("SELECT nomFournisseur, dateCreationFournisseur, mailFournisseur FROM fournisseur WHERE idFournisseur like ? and nomFournisseur like ?;");
                            $requete->bindValue(1,$id);
                            $requete->bindValue(2,$reference);
                            $requete->execute();
                            while ($row=$requete->fetch(PDO::FETCH_OBJ))
                            {
                                array_push($retour,$row->nomFournisseur);
                                array_push($retour,$row->dateCreationFournisseur);
                                array_push($retour,$row->mailFournisseur);
                            }
                            break;
                    }
                    return $retour;
                } else {
                    echo "Aucune table ne correspond.";
                }
            }
            catch(PDOException $e) {
                die("erreur dans la requête ".$e->getMessage());
            }
        }
// Modifier un élément d'un table 
         public function modifyElement($tableauDeLElement) {
            try {
                $element = $tableauDeLElement;
                if ($element[0]=='produit') {
                    // update produit
                     // 0:table | 1:id du produit | 2:date creation | 3:ref | 4:nom | 5:stock | 6:statut | 7:point | 8:description | 9:valeur nutri | 10:id de fournisseur
                    $element = $tableauDeLElement;
                    $requete = $this->conn->prepare("UPDATE produit SET dateCreationProduit = ?, referenceProduit = ?,  nomProduit = ?, stockProduit = ?, statutProduit = ?, nbrPointProduit = ?, descriptionProduit = ?, valeurNutriProduit = ?, idDeFournisseur = ? WHERE idProduit = ?;");
                    $requete->bindValue(1,$element[2]);
                    $requete->bindValue(2,$element[3]);
                    $requete->bindValue(3,$element[4]);
                    $requete->bindValue(4,$element[5]);
                    $requete->bindValue(5,$element[6]);
                    $requete->bindValue(6,$element[7]);
                    $requete->bindValue(7,$element[8]);
                    $requete->bindValue(8,$element[9]);
                    $requete->bindValue(9,$element[10]);
                    $requete->bindValue(10,$element[1]);
                    $retour = $requete->execute();
                }
                elseif ($element[0]=='carte') {
                    $requete = $this->conn->prepare("UPDATE carte SET nbrPointcarte = ?, statut = ?, codeCarte = ?, codePin = ? WHERE idCarte = ?;");
                    $requete->bindValue(1,$element[5]);
                    $requete->bindValue(2,$element[3]);
                    $requete->bindValue(3,$element[2]);
                    $requete->bindValue(4,$element[4]);
                    $requete->bindValue(5,$element[1]);
                    $retour = $requete->execute();
                }
                elseif ($element[0]=='entreprise') {
                    // update entreprise
                    
                    $requete = $this->conn->prepare("UPDATE entreprise SET nomEntreprise = ?, descriptionEntreprise = ?, statutEntreprise = ?, nbrPointEntreprise = ? WHERE idEntreprise = ?;");
                    $requete->bindValue(1,$element[2]);
                    $requete->bindValue(2,$element[4]);
                    $requete->bindValue(3,$element[3]);
                    $requete->bindValue(4,$element[5]);
                    $requete->bindValue(5,$element[1]);
                    $retour = $requete->execute();
                }
                elseif ($element[0]=='fournisseur') {
                    $dateObj = date_create($element[4]);
                    $dateFormat = date_format($dateObj, 'Y-m-d');
                    // table  | id | nom | mail | date de création
                    $requete = $this->conn->prepare("UPDATE fournisseur SET nomFournisseur = ?, mailFournisseur = ?, dateCreationFournisseur = ? WHERE idFournisseur = ?;");
                    $requete->bindValue(1,$element[2]);
                    $requete->bindValue(2,$element[3]);
                    $requete->bindValue(3,$dateFormat);
                    $requete->bindValue(4,intval($element[1]));
                    $retour = $requete->execute();
                }
                else {
                    echo "ERREUR - Aucune table ne correspond.";
                    return false;
                }
                //Execute the query
                $retour = $requete ->execute();

                return $retour;
            }
            catch(PDOException $e) {
                error_log('Erreur dans la requête : '.$e);
                return false;
            }
        }


       /*public function modifyElement($tableauDeLElement) {
            try {
                $element = $tableauDeLElement;
                $table = $element[0];
                $bindings = array_slice($element, 1); // Exclude the table name
        
                switch ($table) {
                    case 'produit':
                        $query = "UPDATE produit SET referenceProduit = ?, dateCreationProduit = ?, nomProduit = ?, stockProduit = ?, statutProduit = ?, nbrPointProduit = ?, descriptionProduit = ?, valeurNutriProduit = ?, idDeFournisseur = ? WHERE idProduit = ?";
                        break;
                    case 'carte':
                        $query = "UPDATE carte SET nbrPointcarte = ?, statut = ?, codeCarte = ?, codePin = ? WHERE idCarte = ?";
                        break;
                    case 'entreprise':
                        $query = "UPDATE entreprise SET nomEntreprise = ?, descriptionEntreprise = ?, statutEntreprise = ?, nbrPointEntreprise = ? WHERE idEntreprise = ?";
                        break;
                    case 'fournisseur':
                        $query = "UPDATE fournisseur SET nomFournisseur = ?, mailFournisseur = ?, dateCreationFournisseur = ? WHERE idFournisseur = ?";
                        break;
                    default:
                        throw new Exception("ERREUR - Aucune table ne correspond.");
                }
        
                $stmt = $this->conn->prepare($query);
                foreach ($bindings as $index => $value) {
                    $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                    $stmt->bindValue($index + 1, $value, $paramType);
                }
        
                $retour = $stmt->execute();
                return $retour;
            } catch (PDOException $e) {
                throw new Exception('Erreur dans la requête : ' . $e->getMessage());
            }
        }*/
        
///
// Affichage d'une liste avec toutes les entreprises (actif et inactif) 
         // Liste des entreprises par ID => affiche le nom, le nbr de point et le statut (actif | inactif)
         public function listeDesEntreprises(){
            try{
                $requete = $this->conn->prepare('SELECT idEntreprise, nomEntreprise, nbrPointEntreprise, statutEntreprise FROM entreprise;');
                $requete->execute();
                $retour='<SELECT name="lesEntreprises">';
                while ( $row = $requete->fetch(PDO::FETCH_OBJ ) )
                {
                    $retour = $retour.'<OPTION value="'.$row->idEntreprise.'">'.$row->nomEntreprise." | points : ".$row->nbrPointEntreprise." | ".$row->statutEntreprise.'</OPTION>';
                }
                $retour = $retour.'</SELECT>';
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête".$e->getMessage());
            }
        }
///
// Affichage d'une liste avec tous les fournisseurs
         // Liste des fournisseurs par ID => affiche le nom uniquement
         public function listeDesFournisseurs($idFournisseurSelectionne = NULL){
            try{
                $requete = $this->conn->prepare('SELECT idFournisseur, nomFournisseur FROM fournisseur;');
                $requete->execute();
                $retour='<SELECT name="lesFournisseurs">';
                while ( $row = $requete->fetch(PDO::FETCH_OBJ ) )
                {
                    $selected = ($row->idFournisseur == $idFournisseurSelectionne) ? 'selected' : '';
                    $retour = $retour.'<OPTION value="'.$row->idFournisseur.'" '.$selected.'>'.$row->nomFournisseur.'</OPTION>';
                }
                $retour = $retour.'</SELECT>';
                return $retour;
            }
            catch(PDOException $e) {
                die("erreur dans la requête".$e->getMessage());
            }
        }
///
// Récupère le nom et le nbr de point de l'entreprise en fonction de l'ID entrée en paramètre
        public function entrepriseChoisie($id) {
            try {
                $requete = $this->conn->prepare('SELECT nomEntreprise, nbrPointEntreprise from entreprise where idEntreprise like ?;');
                $requete->bindValue(1,$id);
                $requete->execute();
                $retour=array();
                while ($row = $requete->fetch(PDO::FETCH_OBJ)) 
                {
                    array_push($retour,$row->nomEntreprise,$row->nbrPointEntreprise);
                }
                return $retour;
            }
            catch(PDOException $e) {
                die ("erreur dans la requête".$e->getMessage());
            }
        }
///
// Permet d'ajouter une carte 
        public function insertCarte($unCodeCarte, $unCodePin, $unNbrPoint, $unIDEntreprise) {
            try {
                $requete = $this->conn->prepare("INSERT INTO carte(codeCarte, codePin, nbrPointcarte, statut, idDeEntreprise) values (?,?,?,?,?);");
                $requete->bindValue(1,$unCodeCarte);
                $requete->bindValue(2,$unCodePin);
                $requete->bindValue(3,$unNbrPoint);
                $requete->bindValue(4,intval('1'));
                $requete->bindValue(5,$unIDEntreprise);
                $requete->execute();
                return $requete;
            }
            catch(PDOException $e) {
                die ("erreur dans la requête".$e->getMessage());
            }

            
        }
///
///
// Méthode pour vérifier si une carte existe déjà dans la base de données pour une entreprise donnée
        public function codePinExist($codePin)
        {
        //la rêquete SQL pour vérifier l'existence de la carte dans la base de données pour l'entreprise spécifiée
            $query = "SELECT COUNT(*) as count FROM carte where codePin =: codePin";
            $stmt = $this ->conn->prepare($query);

        //Binder les paramètres
            $stmt->bindParam(':codePin', $codePin);

        //Exécuter la requête 
            $stmt->execute();

        //Récupérer le nombre de résultats
            $row = $stmt ->fetch(PDO::FETCH_ASSOC);
            $count = $row['count'];

        //Retourner vrai si la carte existe déjà, faux sinon
            return $count > 0;


}
///
// Permet d'ajouter une entreprise 
        public function insertEntreprise($nom, $description, $statut, $point) {
            try {
                $date = date('d/m/Y');
                $dateDuJour = strval($date);

                $requete = $this->conn->prepare("INSERT INTO entreprise(dateCreationEntreprise, nomEntreprise, descriptionEntreprise, statutEntreprise, nbrPointEntreprise) values (?,?,?,?,?);");
                $requete->bindValue(1,$dateDuJour);
                $requete->bindValue(2,$nom);
                $requete->bindValue(3,$description);
                $requete->bindValue(4,$statut);
                $requete->bindValue(5,$point);
                $requete->execute();
                return $requete;
            }
            catch(PDOException $e) {
                die ("erreur dans la requête".$e->getMessage());
            }
        }
///
// Permet d'ajouter un fournisseur 
        public function insertFournisseur($nom, $mail) {
            try {
                $dateDuJour = date('Y-m-d');

                $requete = $this->conn->prepare("INSERT INTO fournisseur(nomFournisseur, dateCreationFournisseur, mailFournisseur) values (?,?,?);");
                $requete->bindValue(1,$nom);
                $requete->bindValue(2,$dateDuJour);
                $requete->bindValue(3,$mail);
                $requete->execute();
                return $requete;
            }
            catch(PDOException $e) {
                die ("erreur dans la requête".$e->getMessage());
            }
        }
///
// Permet d'ajouter un produit 
        public function insertProduit($reference, $nom, $stock, $point, $description, $statut, $valeurNutri, $fournisseur, $urlImage) {
            try
            {
                $retour = [];
                $date = date('d/m/Y');
                $dateDuJour = strval($date);

                $requete = $this->conn->prepare("INSERT INTO produit values (?,?,?,?,?,?,?,?,?,?);");
                $id = $this->chercheIdLibre();
                $requete->bindValue(1, $id);
                $requete->bindValue(2,$reference);
                $requete->bindValue(3,$dateDuJour);
                $requete->bindValue(4,$nom);
                $requete->bindValue(5,$stock);
                $requete->bindValue(6,$statut);
                $requete->bindValue(7,$point);
                $requete->bindValue(8,$description);
                $requete->bindValue(9,$valeurNutri);
                $requete->bindValue(10,$fournisseur);
                $requete->execute();

                if ($requete)
                {
                    array_push($retour, 'produitOK');
                }

                //========================================================================================================================================

                if ($urlImage=='../../Images/rien.png')
                {
                    $nomimg = 'rien';
                }
                else
                {
                    $nomimg = "produit";
                }
                $tailleimg = "inconnu";
                $typeimg = "jpeg ou png";
                $urlimg = $urlImage;
                $principaleimg = '1';

                $requeteimg = $this->conn->prepare("INSERT INTO lesImages values (?,?,?,?,null,?,?,?);");
                $requeteimg->bindValue(1, $id);
                $requeteimg->bindValue(2,$nomimg);
                $requeteimg->bindValue(3,$tailleimg);
                $requeteimg->bindValue(4,$typeimg);
                $requeteimg->bindValue(5,$urlimg);
                $requeteimg->bindValue(6,$principaleimg);
                $requeteimg->bindValue(7,$id);
                $requeteimg->execute();
                if ($requeteimg)
                {
                    array_push($retour, 'imageOK');
                }

                //========================================================================================================================================

                return $retour;
            }
            catch(PDOException $e)
            {
                die ("erreur dans la requête".$e->getMessage());
            }
        }

        //cherche un id libre pour la table produit ET la table lesImages
        private function chercheIdLibre()
        {
            $requete = $this->conn->prepare('select max(idProduit) as id from produit;');
            $requete->execute();
            $id = $requete->fetch(PDO::FETCH_OBJ);
            $id = $id->id;
            $id++;
            $requete = $this->conn->prepare('select idImage from lesImages where idImage = '.$id.';');
            $requete->execute();
            $existe = $requete->fetch(PDO::FETCH_OBJ);
            if ($existe)
            {
                $requete = $this->conn->prepare('select max(idImage) as id from lesImages;');
                $requete->execute();
                $id = $requete->fetch(PDO::FETCH_OBJ);
                $id = $id->id;
                $id++;
            }
            return $id;
        }
}
?>