<?php session_start(['cookie_lifetime'=>900,'cookie_secure'=>true,'cookie_httponly'=>true]);?>
<?php if(!isset($_SESSION['admin']) || $_SESSION['admin']!='adminOK') {
    header('Location: ../../Admin');
    exit();
} ?>
<html lang="fr">
    <head>
        <title>Modifier des éléments</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../admin.css" />
        <script src="../admin.js"></script>
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
try {
    if (isset($_GET['table']) && isset($_GET['id']) && isset($_GET['reference'])) {
        include_once('../pages-multiples/menu-admin.php');
        include_once('../accesBDA.php');
        $maBDA = new accesBDA();
        // ============================================================
         // Récupération des variables en POST
        $table = $_GET['table'];
        $id = $_GET['id'];
        $reference = $_GET['reference'];
        $info = $maBDA->recupererInfo($table, $id, $reference);        
        // ============================================================
        $cas = $table;
        switch($cas) {
            case 'produit':
                ?>
                </br></br>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                        <h1 class="text-center">Modifier les informations</br> du produit</h1>
                        <form id="modifier_form" action='../traitement/traitement-modification.php' method='POST'>
                            <div class="form-group">
                                <!-- Date de création -->
                                </br>
                                <label for="dateCreation">Date de création :</label>
                                <div class="text-center">
                                    <input type="date" class="form-control" id="dateCreation" name="dateCreation" value="<?php echo $info[1]; ?>">
                                </div>
                                </br>
                                <!-- Référence -->
                                <label for="reference">Référence :</label>
                                <div class="text-center">
                                    <input type="text" class="form-control" id="reference" name="reference" value="<?php echo $info[0]; ?>">
                                </div>
                                </br>
                                <!-- Nom -->
                                <label for="nom">Nom :</label>
                                <div class="text-center">
                                    <textarea name="nom" class="form-control" id="nom" style="height: 100px"><?php echo $info[2]; ?></textarea>
                                </div>
                                </br>
                                <!-- Point -->
                                <label for="nbrPoint">Nombre de point :</label>
                                <div class="text-center">
                                    <input type="number" class="form-control" id="nbrPoint" name="nbrPoint" value="<?php echo $info[5]; ?>">
                                </div>
                                </br>
                                <!-- Statut -->
                                <div class="text-center">
                                    <label>Statut :</label>
                                    <div class="radio-container">
                                        <label>
                                            <input type="radio" name="statut" value="1" aria-label="Actif" <?php if ($info[4] === '1') echo 'checked'; ?>>
                                            Actif
                                        </label>
                                        &nbsp &nbsp
                                        <label>
                                            <input type="radio" name="statut" value="0" aria-label="Inactif" <?php if ($info[4] === '0') echo 'checked'; ?>>
                                            Inactif
                                        </label>
                                    </div>
                                </div>
                                </br>
                                <!-- Fournisseur -->
                                <div class="text-center">
                                    <?php echo "<strong>Sélectionnez le fournisseur : </strong>".$maBDA->listeDesFournisseurs($info[8]);?>
                                </div>
                                </br>
                                <!-- Stock -->
                                <label for="stock">Stock :</label>
                                <div class="text-center">
                                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $info[3]; ?>">
                                </div>
                                </br> 
                                <!-- Description -->
                                <div class="col-md-8">
                                    <label for="description" class="form-label">Description :</label>
                                    <textarea name="description" class="form-control" placeholder="Écrivez ici la description..." id="description" style="height: 100px" required><?php echo $info[6]; ?></textarea>
                                </div>
                                </br>
                                <!-- Valeur nutritionnelle -->
                                <div class="col-md-8">
                                    <label for="valeurNutri" class="form-label">Valeur nutritionnelle :</label>
                                    <textarea name="valeurNutri" class="form-control" placeholder="Écrivez ici la description nutritionnelle..." id="valeurNutri" style="height: 100px"><?php echo $info[7]; ?></textarea>
                                    <small class="form-text text-muted">Affichera "Nous ne disposons malheureusement pas de cette information." si le champs n'est pas rempli.</small>
                                </div>
                            </div>
                            </br>
                            <input type="hidden" value="produits" name="table">
                            <input type="hidden" value=<?php echo $id; ?> name="id">
                            <input type="submit" class="btn btn-primary" value="Modifier">
                        </form>
                        </div>
                    </div>
                </div>
                <?php 
                break;
            case 'carte':
                ?>
                </br></br>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                        <h1 class="text-center">Modifier les informations</br> de la carte</h1>
                        <form id="modifier_form" action='../traitement/traitement-modification.php' method='POST'>
                            <div class="form-group">
                                <!-- Code carte -->
                                <label for="codeCarte">Code carte :</label>
                                <div class="text-center">
                                    <input type="text" class="form-control" id="codeCarte" name="codeCarte" value="<?php echo $info[0]; ?>">
                                </div>
                                </br>
                                <!-- Code PIN -->
                                </br>
                                <label for="codePin">Code PIN :</label>
                                <div class="text-center">
                                    <textarea name="codePin" class="form-control" id="codePin" style="height: 100px"><?php echo $info[1]; ?></textarea>
                                </div>
                                </br>
                                <!-- Statut -->
                                <div class="text-center">
                                    <label>Statut :</label>
                                    <div class="radio-container">
                                        <label>
                                            <input type="radio" name="statut" value="1" aria-label="Actif" <?php if ($info[3] === '1') echo 'checked'; ?>>
                                            Actif
                                        </label>
                                        &nbsp &nbsp
                                        <label>
                                            <input type="radio" name="statut" value="0" aria-label="Inactif" <?php if ($info[3] === '0') echo 'checked'; ?>>
                                            Inactif
                                        </label>
                                    </div>
                                </div>
                                </br>
                                <!-- Point -->
                                <label for="nbrPoint">Nombre de point :</label>
                                <div class="text-center">
                                    <input type="number" class="form-control" id="nbrPoint" name="nbrPoint" value="<?php echo $info[2]; ?>">
                                    <?php //TODO: changer le nombre de point de toutes les cartes ?>
                                </div>
                            </div>
                            </br>
                            <input type="hidden" value="cartes" name="table">
                            <input type="hidden" value=<?php echo $id; ?> name="id">
                            <input type="submit" class="btn btn-primary" value="Modifier">
                        </form>
                        </div>
                    </div>
                </div>
                <?php 
                break;
            case 'entreprise':
                ?> 
                </br></br>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                        <h1 class="text-center">Modifier les informations</br> de l'entreprise</h1>
                        <form id="modifier_form" action='../traitement/traitement-modification.php' method='POST'>
                            <div class="form-group">
                                <!-- Nom -->
                                <label for="nom">Nom :</label>
                                <div class="text-center">
                                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $info[1]; ?>">
                                </div>
                                </br>
                                <!-- Description -->
                                </br>
                                <label for="dateCreation">Description :</label>
                                <div class="text-center">
                                    <textarea name="dateCreation" class="form-control" id="dateCreation" style="height: 100px"><?php echo $info[2]; ?></textarea>
                                </div>
                                </br>
                                <!-- Statut -->
                                <div class="text-center">
                                    <label>Statut :</label>
                                    <div class="radio-container">
                                        <label>
                                            <input type="radio" name="statut" value="actif" aria-label="Actif" <?php if ($info[3] === 'actif') echo 'checked'; ?>>
                                            Actif
                                        </label>
                                        &nbsp &nbsp
                                        <label>
                                            <input type="radio" name="statut" value="inactif" aria-label="Inactif" <?php if ($info[3] === 'inactif') echo 'checked'; ?>>
                                            Inactif
                                        </label>
                                    </div>
                                </div>
                                </br>
                                <!-- Point -->
                                <label for="nbrPoint">Nombre de point :</label>
                                <div class="text-center">
                                    <input type="number" class="form-control" id="nbrPoint" name="nbrPoint" value="<?php echo $info[4]; ?>">
                                    <?php //TODO: changer le nombre de point de toutes les cartes ?>
                                </div>
                            </div>
                            </br>
                            <input type="hidden" value="entreprises" name="table">
                            <input type="hidden" value=<?php echo $id; ?> name="id">
                            <input type="submit" class="btn btn-primary" value="Modifier">
                        </form>
                        </div>
                    </div>
                </div>
                <?php 
                break;
            case 'fournisseur':
                ?>
                </br></br>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                        <h1 class="text-center">Modifier les informations</br> du fournisseur</h1>
                        <form id="modifier_form" action='../traitement/traitement-modification.php' method='POST'>
                            <div class="form-group">
                                <!-- Nom -->
                                <label for="nom">Nom :</label>
                                <div class="text-center">
                                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $info[0]; ?>">
                                </div>
                                </br>
                                <!-- Date de création -->
                                </br>
                                <label for="dateCreation">Date de création :</label>
                                <div class="text-center">
                                    <input type="date" class="form-control" id="dateCreation" name="dateCreation" value="<?php echo $info[1]; ?>">
                                </div>
                                </br>
                                <!-- Email -->
                                <label for="mail">Email :</label>
                                <div class="text-center">
                                    <input type="mail" class="form-control" id="mail" name="mail" value="<?php echo $info[2]; ?>">
                                </div>
                                </br>
                            </div>
                            <input type="hidden" value="fournisseurs" name="table">
                            <input type="hidden" value=<?php echo $id; ?> name="id">
                            <input type="submit" class="btn btn-primary" value="Modifier">
                        </form>
                        </div>
                    </div>
                </div>
                <?php 
                break;
        }
        ?>
        <?php 
        
    }
    else {
        echo "Oups, il y a eu une erreur..";
    }
}
catch(PDOException $e) {
    die ("Une erreur est survenu. </br>".$e);
}
?>
    </main>
    </body>
</html>