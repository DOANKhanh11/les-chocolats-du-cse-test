<?php 
?>

<h2>Création des cartes</h2>

<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nbrCarte'])) {

    $nbrCarte = $_POST['nbrCarte'];

    // Tableau de chiffre 0 exclu 
    $tableauNombre = array('1','2','3','4','5','6','7','8','9');

    // Tableau de l'alphabet minuscule l et i et o exclu 
    $tableauAlphabetMinuscule = array('a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z');

    // Tableau de l'alphabet majuscule L et I et O exclu 
    $tableauAlphabetMajuscule = array('A','B','C','D','E','F','G','H','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
    
    // Tableau regroupant les 3 tableaux ci-dessus 
    $toutMelange = array($tableauNombre, $tableauAlphabetMinuscule, $tableauAlphabetMajuscule);

    // Base de la carte 
    $baseCarte = 'BC';

    // Initialisation d'un tableau qui va contenir toutes les cartes demandées 
    $lesCartes = array();

/* ============================================================================================================================= */
    // Création des cartes en fonction du nombre de carte demandé
    for ($compteur = 0; $compteur < $nbrCarte; $compteur++) {

        /* Transformation de la base en tableau pour facilité l'ajout */
        $baseCarteTableau = str_split($baseCarte);

        /* Création des 6 autres caractères de la carte */
        for ($i=0; $i < 6; $i++) {
            // Chiffre random pour choisir le tableau (nombre, alpha minus, alpha maj)
            $tableauConcerne = rand(0,2);
            // Chiffre random pour choisir un chiffre 
            $melTableauNombre = rand(0,8); 
            // Chiffre random pour choisir une lettre 
            $melTableauAlphabet = rand(0,22);

            // Si le tableau est celui de nombre 
            if ($tableauConcerne==0) {
                // On choisi le tableau de nombre et on choisit un nom aléatoire dedans
                $nombre = $toutMelange[$tableauConcerne][$melTableauNombre];
                // Ajout du nombre au tableau de la carte 
                array_push($baseCarteTableau,$nombre);
            }
            // Si le tableau est celui de l'alphabet 
            if ($tableauConcerne==1 || $tableauConcerne==2) {
                // On choisit le tableau de l'alphabet (min ou maj) et on choisit une lettre aléatoire dedans 
                $lettre = $toutMelange[$tableauConcerne][$melTableauAlphabet];
                // Ajout de la lettre (min ou maj) au tableau de la carte 
                array_push($baseCarteTableau,$lettre);
            }
        }
        /* Affichage du tableau */
        //echo 'Tableau pour UNE carte : '; print_r($baseCarteTableau);
        
        /* Tranformation du tableau en chaine de caractère */
        $codeCarte = implode($baseCarteTableau);

        /* Affichage du code pin de la carte */
        //echo 'Code finale de la carte : '.$codeCarte.'<br>';


        /* Création d'un tableau pour la carte et l'entreprise associée */
        $uneCarteEtUneEntreprise[] = array($codeCarte,"csechocolat");
        /* Ajout de la carte créée dans le tableau */
        array_push($lesCartes, $uneCarteEtUneEntreprise);

        /* Permet de retirer les doublons de code pin */
        $lesCartes = array_map("unserialize", array_unique(array_map("serialize", $lesCartes)));
    }
    /* Renvoie tous les codes (cartes et pin) dans un tableau */
    $tableauDefinitifCartes = array_slice($lesCartes, -1);
/* ============================================================================================================================= */
    /* Affichage du tableau avec les cartes créées */
    //print_r($lesCartes);

    /* Affichage de nombre de carte générées */
    echo '<br> Nombre total de <b>cartes générées</b> : '.count($lesCartes);
    echo '<br> Nombre de cartes demandées : '.$nbrCarte;

    /* Affiche le nombre de carte à recréer (si il y a des doublons qui ont été supprimé) */
    if (count($lesCartes)!=$nbrCarte) {
        $nbrARecreer = $nbrCarte - count($lesCartes);
        echo 'Il manque '.$nbrARecreer.' carte(s) à recréer';
    }
?>
<?php 
    include('../accesBDA.php'); 
    $maBDA = new accesBDA();
?>
    <form action="../traitement/creation-carte-fichier-csv.php" method="POST">
        <br><br>
        
        <?php echo "Sélectionnez l'entreprise concernée : ".$entrepriseChoisie = $maBDA->listeDesEntreprises();?>
        <div class="col-md-8">
            <input type='text' name="nomFichier" size="30" class="form-control" placeholder="Nom du fichier (sans le format)" required/>
            <input type="hidden" name="lesCartes" value="<?php echo base64_encode(json_encode($tableauDefinitifCartes)); ?>" />
        </div>
        <button class="btn btn-secondary " type="submit">Envoyer</button>
    </form>
<?php 
} 
else {
    echo "Erreur lors de la génération des cartes. <br> Veuillez recommencer l'opération.";
}
?>
