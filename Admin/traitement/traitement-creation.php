<html lang="fr">
    <head>
        <title>Création des éléments</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../admin.css" />
        <link rel="icon" type="image/png" href="../../Vues/design/images/favicon-chocolats-cse.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <!-- Inclusion des fichiers CSS de Bootstrap -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <!-- Inclusion des scripts JavaScript de Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <main>
<?php
include_once('../pages-multiples/menu-admin.php');
include_once('../accesBDA.php');
$maBDA = new accesBDA();
?>
<?php 
if (isset($_GET['param'])) {
    $cas = $_GET['param'];
    switch ($cas) {
        case 'produits':
            ?>
            <div>
                </br></br>
                <h3>Création d'un produit</h3>
                </br>
            </div>
            <?php 
                $reference = $_POST['reference'];
                $nom = $_POST['nom'];
                $stock = $_POST['stock'];
                $point = $_POST['point'];
                $description = $_POST['description'];
                $statut = $_POST['statut'];
                $fournisseur = $_POST['lesFournisseurs'];
                if (isset($_POST['valeurNutri']) && !empty($_POST['valeurNutri'])) {
                    $valeurNutri = $_POST['valeurNutri'];
                } else {
                    $valeurNutri = "Nous ne disposons malheureusement pas de cette information.";
                }
                $image = $_FILES['imageProduit'];
                
                if ($image['error'] === UPLOAD_ERR_OK) {
                    $nomFichier = $image['name'];
                    $emplacementTemp = $image['tmp_name'];
                    $destination = '../../Images/' . $nomFichier;

                    //Déplacer le fichier vers la description finale 
                    if (move_uploaded_file($emplacementTemp, $destination)) {
                        echo "L'image a été téléchargée avec succès !";

                        $urlImage = '../../Images/' . $nomFichier;
                    } else {
                        echo "Une erreur est survenue lors du téléchargement de l'image. <strong>L'image par défaut sera affichée.</strong>";
                        $urlImage = '../../Images/rien.png';
                    }

                } else {
                    $urlImage =  '../../Images/rien.png';
                }
                if (!isset($urlImage) || empty($urlImage)) 
                {
                    echo "L'image n'existe pas. Veuillez réessayer la création.";
                } else {
                    $produitCreer = $maBDA->insertProduit($reference, $nom, $stock, $point, $description, $statut, $valeurNutri, $fournisseur, $urlImage);
                    if ($produitCreer) {
                        echo '<p>Le produit a bien été créé !</p>';
                    }
                    else {
                        echo '<p><strong>Erreur lors de la création.</strong></p>';
                        echo '<p>Veuillez recommencer l\'opération.</p>';
                    }
                }     
            ?>
            
            <?php 
            break;
        case 'cartes': 
            ?>
            <div>
                </br></br>
                <h3>Création des cartes</h3>
                </br>
            </div>
            <?php include_once('../traitement/creation-carte.php'); ?>

            <?php 
            break;
        case 'entreprises':
            ?>
            <div>
                </br></br>
                <h3>Création d'une entreprise</h3>
                </br>
            </div>
            <?php 
                $nom = $_POST['nom'];
                $description = $_POST['description'];
                $statut = $_POST['statut'];
                $point = $_POST['point'];
                $entrepriseCreer = $maBDA->insertEntreprise($nom, $description, $statut, $point);
                if ($entrepriseCreer) {
                    echo '<p>L\'entreprise a bien été créé !</p>';
                }
                else {
                    echo '<p><strong>Erreur lors de la création.</strong></p>';
                    echo '<p>Veuillez recommencer l\'opération.</p>';
                }
            ?>
            <?php 
            break;
        case 'fournisseurs':
            ?>
             <div>
                </br></br>
                <h3>Création d'un fournisseur</h3>
                </br>
            </div>
            <?php 
                $nom = $_POST['nom'];
                $mail = $_POST['mail'];
                $fournisseurCreer = $maBDA->insertFournisseur($nom, $mail);
                if ($fournisseurCreer) {
                    echo '<p>Le fournisseur a bien été créé !</p>';
                }
                else {
                    echo '<p><strong>Erreur lors de la création.</strong></p>';
                    echo '<p>Veuillez recommencer l\'opération.</p>';
                }
            ?>
            
            <?php 
            break;
    }
}
else {
    "Une erreur est survenue.";
}
?>
    </main>
        <script src="../admin.js"></script>
    </body>
</html>