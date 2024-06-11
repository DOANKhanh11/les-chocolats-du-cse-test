<?php session_start(['cookie_lifetime'=>900,'cookie_secure'=>true,'cookie_httponly'=>true]);?>
<?php if(!isset($_SESSION['admin']) || $_SESSION['admin']!='adminOK') {
    header('Location: ../../Admin');
    exit();
} ?>
<html lang="fr">
    <head>
        <title>Rechercher des éléments</title>
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
                <h3>Page de création d'un produit</h3>
                </br>
            </div>
            <div class="col-md-5">
                <form action="../traitement/traitement-creation.php?param=produits" method="POST" enctype="multipart/form-data">
                    <div class="col-md-8">
                        <label for="inputRef" class="form-label">Référence du produit</label>
                        <input type="text" name="reference" class="form-control" id="inputRef" placeholder="Référence" required>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputNom" class="form-label">Nom du produit</label>
                        <input type="text" name="nom" class="form-control" id="inputNom" placeholder="Nom" required>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputStock" class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" id="inputStock" placeholder="Stock (entre 1 et 5 000)" min=1 max=5000 required>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputPoint" class="form-label">Point</label>
                        <input type="number" name="point" class="form-control" id="inputPoint" placeholder="Point à l'unité" min=1 required>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <?php echo "<strong>Sélectionnez le fournisseur : </strong>".$maBDA->listeDesFournisseurs();?>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputDescription" class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Écrivez ici la description..." id="inputDescription" style="height: 100px" required></textarea>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputValeurNutri" class="form-label">Valeur nutritionnelle</label>
                        <textarea name="valeurNutri" class="form-control" placeholder="Écrivez ici la description nutritionnelle..." id="inputValeurNutri" style="height: 100px"></textarea>
                        <small class="form-text text-muted">Affichera "Nous ne disposons malheureusement pas de cette information." si le champs n'est pas rempli.</small>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label>Statut :</label>
                        <div class="radio-container">
                            <label>
                                <input type="radio" name="statut" value="1" aria-label="Actif" checked>
                                Actif
                            </label>
                            &nbsp &nbsp
                            <label>
                                <input type="radio" name="statut" value="0" aria-label="Inactif">
                                Inactif
                            </label>
                        </div>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="imgProduit" class="form-label">Image principal du produit</label>
                        <input id="imgProduit" type="file" name="imageProduit">
                        <small class="form-text text-muted">Affichera l'image par défaut si aucune image sélectionnée.</small>
                    </div>
                    </br>
                    <div class="col-12">
                        <button class="btn btn-secondary " type="reset">Annuler</button> &nbsp &nbsp
                        <button class="btn btn-secondary " type="submit">Envoyer</button>
                    </div>
                </form>
            </div> 
            
            <?php 
            break;
        case 'cartes': 
            ?>
            <div>
                </br></br>
                <h3>Page de création des cartes</h3>
                </br>
            </div>
            <div class="col-md-5">
                <form action="../traitement/traitement-creation.php?param=cartes" method="POST">
                    <div class="col-md-8">
                        <label for="inputnbr" class="form-label">Combien de cartes voulez-vous ?</label>
                        <input type="number" name="nbrCarte" class="form-control" id="inputnbr" placeholder="Nombre entre 1 et 1 000 000" min=1 max=1000000 required>
                    </div>
                    </br>
                    <?php echo "Sélectionnez l'entreprise concernée : ".$maBDA->listeDesEntreprises();?>
                    </br></br>
                    <div class="col-md-8">
                        <input type='text' name="nomFichier" size="30" class="form-control" placeholder="Nom du fichier (sans le format)" required/>
                        <small class="form-text text-muted">Le fichier sera téléchargeable après l'envoie. FORMAT CSV</small>

                    </div>
                    </br>
                    <div class="col-12">
                        <button class="btn btn-secondary " type="reset">Annuler</button> &nbsp &nbsp
                        <button class="btn btn-secondary " type="submit">Envoyer</button>
                    </div>
                </form>
            </div>            
            <?php 
            break;
        case 'entreprises':
            ?>
            <div>
                </br></br>
                <h3>Page de création d'une entreprise</h3>
                </br>
            </div>
            <div class="col-md-5">
                <form action="../traitement/traitement-creation.php?param=entreprises" method="POST">
                    <div class="col-md-8">
                        <label for="inputNom" class="form-label">Nom de l'entreprise</label>
                        <input type="text" name="nom" class="form-control" id="inputNom" placeholder="Entrez le nom" required>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputPoint" class="form-label">Nombre de point</label>
                        <input type="number" name="point" class="form-control" id="inputPoint" placeholder="Entrez le nombre" min=1 required>
                        <small class="form-text text-muted">Les cartes créées auront toutes ce nombre de point initialement.</small>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputDescription" class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Écrivez ici la description..." id="inputDescription" style="height: 100px" required></textarea>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label>Statut :</label>
                        <div class="radio-container">
                            <label>
                                <input type="radio" name="statut" value="actif" aria-label="Actif" checked>
                                Actif
                            </label>
                            &nbsp &nbsp
                            <label>
                                <input type="radio" name="statut" value="inactif" aria-label="Inactif">
                                Inactif
                            </label>
                        </div>
                    </div>
                    </br>
                    <div class="col-12">
                        <button class="btn btn-secondary " type="reset">Annuler</button> &nbsp &nbsp
                        <button class="btn btn-secondary " type="submit">Envoyer</button>
                    </div>
                </form>
            </div> 
            
            <?php 
            break;
        case 'fournisseurs':
            ?>
            <div>
                </br></br>
                <h3>Page de création d'un fournisseur</h3>
                </br>
            </div>
            <div class="col-md-5">
                <form action="../traitement/traitement-creation.php?param=fournisseurs" method="POST">
                    <div class="col-md-8">
                        <label for="inputNom" class="form-label">Nom du fournisseur</label>
                        <input type="text" name="nom" class="form-control" id="inputNom" placeholder="Entrez le nom" required>
                    </div>
                    </br>
                    <div class="col-md-8">
                        <label for="inputMail" class="form-label">Email</label>
                        <input type="email" name="mail" class="form-control" id="inputMail" placeholder="Entrez le mail du fournisseur" required>
                        <small class="form-text text-muted">Les commandes seront envoyées à cette adresse mail.</small>
                    </div>
                    </br>
                    <div class="col-12">
                        <button class="btn btn-secondary " type="reset">Annuler</button> &nbsp &nbsp
                        <button class="btn btn-secondary " type="submit">Envoyer</button>
                    </div>
                </form>
            </div> 
            
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