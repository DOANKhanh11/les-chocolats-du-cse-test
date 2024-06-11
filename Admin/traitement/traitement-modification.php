<html lang="fr">
    <head>
        <title>Modification des éléments</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../admin.css" />
        <link rel="icon" type="image/png" href="../../Vues/design/images/favicon-chocolats-cse.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <!-- Inclusion des fichiers CSS de Bootstrap -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <!-- Inclusion des scripts JavaScript de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    </head>
    <body>
        <main>
<?php
include_once('../pages-multiples/menu-admin.php');
include_once('../accesBDA.php');
$maBDA = new accesBDA();
?>
<?php 
if (isset($_POST['table'])) {
    $cas = $_POST['table'];
    switch ($cas) {
        case 'produits':
            ?>
            <div>
                </br></br>
                <h3>Modification d'un produit</h3>
                </br>
            </div>
            <?php
                try {
                    // Vérifier si la requête est de type POST et de la bonne table
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Récupérer les données du formulaire
                        $table = 'produit';
                        $id = $_POST['id'];
                        $dateCreation = $_POST['dateCreation'];
                        $reference = $_POST['reference'];
                        $nom = $_POST['nom'];
                        $stock = $_POST['stock'];
                        $statut = $_POST['statut'];
                        $nbrPoint = $_POST['nbrPoint'];
                        $description = $_POST['description'];
                        $valeurNutri = $_POST['valeurNutri'];
                        $lesFournisseurs = $_POST['lesFournisseurs'];
                        $tableau = [];
                        array_push($tableau,$table);
                        array_push($tableau,$id);
                        array_push($tableau,$dateCreation);
                        array_push($tableau,$reference);
                        array_push($tableau,$nom);
                        array_push($tableau,$stock);
                        array_push($tableau,$statut);
                        array_push($tableau,$nbrPoint);
                        array_push($tableau,$description);
                        array_push($tableau,$valeurNutri);
                        array_push($tableau,$lesFournisseurs);

                        // Modification dans la BD 
                        $response = $maBDA->modifyElement($tableau);

                        if ($response) {
                            $response = "Les informations ont été mises à jour avec succès.";
                        }
                        else {
                            $response = "<strong>ERREUR - Les informations n'ont pas été mise à jour.</strong>";
                        }
                        echo $response;
                    }
                    else {
                        $response = "Erreur : méthode de requête invalide.";
                        echo $response;
                    }
                }
                catch(PDOException $e) {
                    die('Erreur dans le traitement de la modification. </br>'.$e);
                }
            ?>
            <?php 
            break;
        case 'cartes': 
            ?>
            <div>
                </br></br>
                <h3>Modification des cartes</h3>
                </br>
            </div>
            <?php
                try {
                    // Vérifier si la requête est de type POST et de la bonne table
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Récupérer les données du formulaire
                        $table = 'carte';
                        $id = $_POST['id'];
                        $codeCarte = $_POST['codeCarte'];
                        $statut = $_POST['statut'];
                        $codePin = $_POST['codePin'];
                        $nbrPoint = $_POST['nbrPoint'];
                        $tableau = [];
                        array_push($tableau,$table);
                        array_push($tableau,$id);
                        array_push($tableau,$codeCarte);
                        array_push($tableau,$statut);
                        array_push($tableau,$codePin);
                        array_push($tableau,$nbrPoint);

                        // Modification dans la BD 
                        $response = $maBDA->modifyElement($tableau);

                        if ($response) {
                            $response = "Les informations ont été mises à jour avec succès.";
                        }
                        else {
                            $response = "<strong>ERREUR - Les informations n'ont pas été mise à jour.</strong>";
                        }
                        echo $response;
                    }
                    else {
                        $response = "Erreur : méthode de requête invalide.";
                        echo $response;
                    }
                }
                catch(PDOException $e) {
                    die('Erreur dans le traitement de la modification. </br>'.$e);
                }
            ?>
            <?php 
            break;
        case 'entreprises':
            ?>
            <div>
                </br></br>
                <h3>Modification d'une entreprise</h3>
                </br>
            </div>
            <?php
                try {
                    // Vérifier si la requête est de type POST et de la bonne table
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Récupérer les données du formulaire
                        $table = 'entreprise';
                        $id = $_POST['id'];
                        $nom = $_POST['nom'];
                        $statut = $_POST['statut'];
                        $dateCreation = $_POST['dateCreation'];
                        $nbrPoint = $_POST['nbrPoint'];
                        $tableau = [];
                        array_push($tableau,$table);
                        array_push($tableau,$id);
                        array_push($tableau,$nom);
                        array_push($tableau,$statut);
                        array_push($tableau,$dateCreation);
                        array_push($tableau,$nbrPoint);

                        // Modification dans la BD 
                        $response = $maBDA->modifyElement($tableau);

                        if ($response) {
                            $response = "Les informations ont été mises à jour avec succès.";
                        }
                        else {
                            $response = "<strong>ERREUR - Les informations n'ont pas été mise à jour.</strong>";
                        }
                        echo $response;
                    }
                    else {
                        $response = "Erreur : méthode de requête invalide.";
                        echo $response;
                    }
                }
                catch(PDOException $e) {
                    die('Erreur dans le traitement de la modification. </br>'.$e);
                }
            ?>

            <?php 
            break;
        case 'fournisseurs':
            ?>
             <div>
                </br></br>
                <h3>Modification d'un fournisseur</h3>
                </br>
            </div>
            <?php
                try {
                    // Vérifier si la requête est de type POST et de la bonne table
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Récupérer les données du formulaire
                        $table = 'fournisseur';
                        $id = $_POST['id'];
                        $nom = $_POST['nom'];
                        $mail = $_POST['mail'];
                        $dateCreation = $_POST['dateCreation'];
                        $tableau = [];
                        array_push($tableau,$table);
                        array_push($tableau,$id);
                        array_push($tableau,$nom);
                        array_push($tableau,$mail);
                        array_push($tableau,$dateCreation);

                        // Modification dans la BD 
                        $response = $maBDA->modifyElement($tableau);

                        if ($response) {
                            $response = "Les informations ont été mises à jour avec succès.";
                        }
                        else {
                            $response = "<strong>ERREUR - Les informations n'ont pas été mise à jour.</strong>";
                        }
                        echo $response;
                    }
                    else {
                        $response = "Erreur : méthode de requête invalide.";
                        echo $response;
                    }
                }
                catch(PDOException $e) {
                    die('Erreur dans le traitement de la modification. </br>'.$e);
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