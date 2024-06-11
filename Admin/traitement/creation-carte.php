<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nbrCarte']) && isset($_POST['lesEntreprises']) && isset($_POST['nomFichier'])) {

    // Récup POST
    $nbrCarte = $_POST['nbrCarte'];
    $entreprise = $_POST['lesEntreprises'];
    $nomFichier = $_POST['nomFichier'] . '.csv';
    // Créer chemin CSV
    $cheminDossier = '../fichier-csv-carte/';
    $cheminFichier = $cheminDossier . $nomFichier;
    // Info entreprise
    $infoEntreprise = $maBDA->entrepriseChoisie($entreprise);
    $nomEntrepriseSansEspace = str_replace(' ', '', $infoEntreprise[0]);
    $nomEntrepriseSansCaractereSpeciaux = replaceSpecialChar($nomEntrepriseSansEspace);
    $codeCarteEntreprise = strtolower($nomEntrepriseSansCaractereSpeciaux);
    $nbrPoint = $infoEntreprise[1];


    // Tableau de l'alphabet minuscule      l et i et o exclu 
    $caracteresPossibles = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';

    // Initialisation du générateur de nombres aléatoires
    mt_srand(0,MT_RAND_PHP);

/* ============================================================================================================================= */

    // Générer un nom de fichier si celui donné existe déjà 
    if (file_exists($cheminFichier)) {
        $index = 1;
        $extension = pathinfo($nomFichier, PATHINFO_EXTENSION);
        $nomFichierSansExtension = pathinfo($nomFichier, PATHINFO_FILENAME);
    
        while (file_exists($cheminFichier)) {
            $nomFichier = $nomFichierSansExtension . '_' . $index . '.' . $extension;
            $cheminFichier = $cheminDossier . $nomFichier;
            $index++;
        }
    }

    
    // On ouvre la fichier CSV à son chemin 
    $fichierCSV = fopen($cheminFichier, 'w');
    
    // Création des cartes en fonction du nombre de carte demandé
    for ($compteur = 0; $compteur < $nbrCarte; $compteur++) {

        // Base de la carte 
        $codePin = 'BC';
        // Création des 6 autres caractères de la carte 
            for ($j=0; $j < 6; $j++) {
                $caractereAleatoire = $caracteresPossibles[mt_rand(0, strlen($caracteresPossibles) - 1)];
                $codePin .=$caractereAleatoire;
                }

            // Enregistrement des cartes sur fichiers CSV
            if ($fichierCSV !== false) {
                $codeCarte = $codeCarteEntreprise;
                fputcsv($fichierCSV, array($codeCarte, $codePin), ';');//à mettre après l'ajout de la carte dans la base de données
                } else {
                    echo "Erreur lors de l'ouverture du fichier CSV.";
                }
                $enregistrerCarte = $maBDA->insertCarte($codeCarte, $codePin, $nbrPoint, $entreprise);
            
        

        //faire en sorte qu'il y ai une vérification de la non existance de la carte  
        //on mettra la ligne juste au dessus dans un while d'une manière ou d'une autre, de manière à essayer jusque ce que ça fonctionne
    }
    fclose($fichierCSV);

    if (isset($enregistrerCarte)) {
        echo '<p>Les cartes sont enregistrées dans la base de données.</p>';
      }
      else {
          echo '<p><strong>Erreur lors de la création.</strong></p>';
          echo '<p>Veuillez recommencer l\'opération.</p>';
      }
      
      echo '</br>';
      echo 'Un fichier CSV a été créé avec les codes PIN et les codes Cartes.';
      echo '</br></br>Cliquez ici pour le télécharger : <a href="'.$cheminFichier.'"><h4>TÉLÉCHARGER</h4></a>';
      
?>

<?php 
} 
else {
    echo "Erreur lors de la génération des cartes. <br> Veuillez recommencer l'opération.";
}
?>

<!-- /* ============================================================================================================================= */
/* ============================================================================================================================= */
/* ============================================================================================================================= */ -->

<?php 
  function replaceSpecialChar($str) {
    $ch0 = array( 
        "œ" => "oe", "Œ" => "OE",
        "æ" => "ae", "Æ" => "AE",
        "À" => "A", "Á" => "A", "Â" => "A", "Ä" => "A", "Å" => "A", "&#256;" => "A", "&#258;" => "A", "&#461;" => "A", "&#7840;" => "A", "&#7842;" => "A", "&#7844;" => "A", "&#7846;" => "A", "&#7848;" => "A", "&#7850;" => "A", "&#7852;" => "A", "&#7854;" => "A", "&#7856;" => "A", "&#7858;" => "A", "&#7860;" => "A", "&#7862;" => "A", "&#506;" => "A", "&#260;" => "A",
        "á" => "a", "â" => "a", "à" => "a", "ä" => "a", "å" => "a", "&#257;" => "a", "&#259;" => "a", "&#462;" => "a", "&#7841;" => "a", "&#7843;" => "a", "&#7845;" => "a", "&#7847;" => "a", "&#7849;" => "a", "&#7851;" => "a", "&#7853;" => "a", "&#7855;" => "a", "&#7857;" => "a", "&#7859;" => "a", "&#7861;" => "a", "&#7863;" => "a", "&#507;" => "a", "&#261;" => "a",
        "Ç" => "C", "&#262;" => "C", "&#264;" => "C", "&#266;" => "C", "&#268;" => "C",
        "ç" => "c", "&#263;" => "c", "&#265;" => "c", "&#267;" => "c", "&#269;" => "c",
        "Ð" => "D", "&#270;" => "D", "&#272;" => "D", "&#271;" => "d", "&#273;" => "d",
        "È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E", "&#274;" => "E", "&#276;" => "E", "&#278;" => "E", "&#280;" => "E", "&#282;" => "E", "&#7864;" => "E", "&#7866;" => "E", "&#7868;" => "E", "&#7870;" => "E", "&#7872;" => "E", "&#7874;" => "E", "&#7876;" => "E", "&#7878;" => "E",
        "è" => "e", "é" => "e", "ê" => "e", "ë" => "e", "&#275;" => "e", "&#277;" => "e", "&#279;" => "e", "&#281;" => "e", "&#283;" => "e", "&#7865;" => "e", "&#7867;" => "e", "&#7869;" => "e", "&#7871;" => "e", "&#7873;" => "e", "&#7875;" => "e", "&#7877;" => "e", "&#7879;" => "e",
        "&#284;" => "G", "&#286;" => "G", "&#288;" => "G", "&#290;" => "G", "&#285;" => "g", "&#287;" => "g", "&#289;" => "g", "&#291;" => "g",
        "&#292;" => "H", "&#294;" => "H", "&#293;" => "h", "&#295;" => "h",
        "&#308;" => "J", "&#309;" => "j",
        "&#310;" => "K", "&#311;" => "k",
        "Ñ" => "N", "&#323;" => "N", "&#325;" => "N", "&#327;" => "N",
        "ñ" => "n", "&#324;" => "n", "&#326;" => "n", "&#328;" => "n", "&#329;" => "n",
        "&#340;" => "R", "&#342;" => "R", "&#344;" => "R", "&#341;" => "r", "&#343;" => "r", "&#345;" => "r",
        "&#346;" => "S", "&#348;" => "S", "&#350;" => "S", "&#347;" => "s", "&#349;" => "s", "&#351;" => "s",
        "&#354;" => "T", "&#356;" => "T", "&#358;" => "T", "&#355;" => "t", "&#357;" => "t", "&#359;" => "t",
        "Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U", "&#360;" => "U", "&#362;" => "U", "&#364;" => "U", "&#366;" => "U", "&#368;" => "U", "&#370;" => "U", "&#431;" => "U", "&#467;" => "U", "&#469;" => "U", "&#471;" => "U", "&#473;" => "U", "&#475;" => "U", "&#7908;" => "U", "&#7910;" => "U", "&#7912;" => "U", "&#7914;" => "U", "&#7916;" => "U", "&#7918;" => "U", "&#7920;" => "U",
        "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "&#361;" => "u", "&#363;" => "u", "&#365;" => "u", "&#367;" => "u", "&#369;" => "u", "&#371;" => "u", "&#432;" => "u", "&#468;" => "u", "&#470;" => "u", "&#472;" => "u", "&#474;" => "u", "&#476;" => "u", "&#7909;" => "u", "&#7911;" => "u", "&#7913;" => "u", "&#7915;" => "u", "&#7917;" => "u", "&#7919;" => "u", "&#7921;" => "u",
        "&#372;" => "W", "&#7808;" => "W", "&#7810;" => "W", "&#7812;" => "W", "&#373;" => "w", "&#7809;" => "w", "&#7811;" => "w", "&#7813;" => "w",
        "Ý" => "Y", "&#374;" => "Y", "?" => "Y", "&#7922;" => "Y", "&#7928;" => "Y", "&#7926;" => "Y", "&#7924;" => "Y", "ý" => "y", "ÿ" => "y", "&#375;" => "y", "&#7929;" => "y", "&#7925;" => "y", "&#7927;" => "y", "&#7923;" => "y",
        "&#377;" => "Z", "&#379;" => "Z", 
        '\'' => "", "\"" => "", "&" => "", "@" => "", "!" => "",  "/" => "", "+" => "", "*" => "", "=" => "", "-" => "", "_" => "", "," => "", ";" => ""
    );             
    

    // Remplace les caractères du string 
    $str = strtr($str,$ch0);
    return $str;
}
?>

