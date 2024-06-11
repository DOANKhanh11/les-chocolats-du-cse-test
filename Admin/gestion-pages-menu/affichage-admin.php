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
$maBD = new accesBDA();
// ============================================================
// Produits 
$nbrTotalProduits = $maBD->calculTotalProduits();
$nbrTotalProduitsActifs = $maBD->calculTotalProduitsActifs();
$nbrTotalProduitsInactifs = $maBD->calculTotalProduitsInactifs();
$nbrTotalProduitsActifsEtStock = $maBD->calculTotalProduitsActifsEtStock();
// ============================================================
// Cartes 
$nbrTotalCartes = $maBD->calculTotalCartes();
$nbrTotalCartesActifs = $maBD->calculTotalCartesActifs();
$nbrTotalCartesInactifs = $maBD->calculTotalCartesInactifs();
// ============================================================
// Entreprises 
$nbrTotalEntreprises = $maBD->calculTotalEntreprises();
$nbrTotalEntreprisesActifs = $maBD->calculTotalEntreprisesActifs();
$nbrTotalEntreprisesInactifs = $maBD->calculTotalEntreprisesInactifs();
// ============================================================
// Fournisseurs 
$nbrTotalFournisseurs = $maBD->calculTotalFournisseurs();
// ============================================================
?>
<div>
    </br></br>
    <h3>Pour effectuer une recherche, cliquer sur l'icône en bas à droite.</h3>
    <h4>Note : pour afficher tout, lancer une recherche vide.</h4>
    </br>
    <span id="p-nbr-resultat">Total résultat de la recherche</span>
</div>
<div id="search-icon">
    <i class="fas fa-search"></i>
</div>
<?php 
if (isset($_GET['param'])) {
    $cas = $_GET['param'];
    switch ($cas) {
        case 'produits':
            ?>
            <form id="search-form" class="d-flex recherche-admin" role="search">
                <p>Recherche par : référence, nom, fournisseur, point.</p>
                <input id="search-input-produits" class="form-control me-2" type="search" placeholder="..." aria-label="Search"></br>
                <button class="btn btn-outline-success" style="width:50%;text-align:center;" type="submit">Rechercher</button>
            </form>
            <table class="table table-striped">
                <thead id="table-head">
                    <tr>
                        <th scope="col">Nombre total de produits</th>
                        <th scope="col">Produits actifs</th>
                        <th scope="col">Produits inactifs</th>
                        <th scope="col">Actif et stock en dessous de 10</th>
                    </tr>
                </thead>
                    
                <tbody id="table-body">
                    <tr>
                        <td><?php echo $nbrTotalProduits; ?></td>
                        <td><?php echo $nbrTotalProduitsActifs; ?></td>
                        <td><?php echo $nbrTotalProduitsInactifs; ?></td>
                        <td><?php echo $nbrTotalProduitsActifsEtStock.' produits'; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php 
            break;
        case 'cartes': 
            ?>
            <form id="search-form" class="d-flex recherche-admin" role="search">
                <p>Recherche par : codePin, codeCarte, entreprise, point.</p>
                <input id="search-input-cartes" class="form-control me-2" type="search" placeholder="..." aria-label="Search"></br>
                <button class="btn btn-outline-success" style="width:50%;text-align:center;" type="">Rechercher</button>
            </form>
            <table class="table table-striped">
                <thead id="table-head">
                    <tr>
                        <th scope="col">Nombre total de cartes</th>
                        <th scope="col">Cartes actifs</th>
                        <th scope="col">Cartes inactifs</th>
                    </tr>
                </thead>
                    
                <tbody id="table-body">
                    <tr>
                        <td><?php echo $nbrTotalCartes; ?></td>
                        <td><?php echo $nbrTotalCartesActifs; ?></td>
                        <td><?php echo $nbrTotalCartesInactifs; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php 
            break;
        case 'entreprises':
            ?>
            <form id="search-form" class="d-flex recherche-admin" role="search">
                <p>Recherche par : nom, point.</p>
                <input id="search-input-entreprises" class="form-control me-2" type="search" placeholder="..." aria-label="Search"></br>
                <button class="btn btn-outline-success" style="width:50%;text-align:center;" type="">Rechercher</button>
            </form>
            <table class="table table-striped">
                <thead id="table-head">
                    <tr>
                        <th scope="col">Nombre total d'entreprises</th>
                        <th scope="col">Entreprises actifs</th>
                        <th scope="col">Entreprises inactifs</th>
                    </tr>
                </thead>
                    
                <tbody id="table-body">
                    <tr>
                        <td><?php echo $nbrTotalEntreprises; ?></td>
                        <td><?php echo $nbrTotalEntreprisesActifs; ?></td>
                        <td><?php echo $nbrTotalEntreprisesInactifs; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php 
            break;
        case 'fournisseurs':
            ?>
            <form id="search-form" class="d-flex recherche-admin" role="search">
                <p>Recherche par : nom, mail.</p>
                <input id="search-input-fournisseurs" class="form-control me-2" type="search" placeholder="..." aria-label="Search"></br>
                <button class="btn btn-outline-success" style="width:50%;text-align:center;" type="">Rechercher</button>
            </form>
            <table class="table table-striped">
                <thead id="table-head">
                    <tr>
                        <th scope="col">Nombre total de fournisseurs</th>
                    </tr>
                </thead>
                    
                <tbody id="table-body">
                    <tr>
                        <td><?php echo $nbrTotalFournisseurs; ?></td>
                    </tr>
                </tbody>
            </table>
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
        <script>
            performSearchProduit();
        </script>
    </body>
</html>