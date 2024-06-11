<?php session_start(['cookie_lifetime'=>900,'cookie_secure'=>true,'cookie_httponly'=>true]);?>
<?php if(!isset($_SESSION['admin']) || $_SESSION['admin']!='adminOK') {
    header('Location: ../../Admin');
    exit();
} ?>
<html lang="fr">
                <head>
                    <title>Affichage des commandes</title>
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
                <!-- Navigation -->
                    <?php include_once('../pages-multiples/menu-admin.php'); ?>
                <!-- Main -->
                    <main>
                        <?php 
                            include_once('../accesBDA.php');
                            $maBDA = new accesBDA();
                            $nbrTotalCommandes = $maBDA->calculTotalCommandes();
                            $nbrTotalCommandesParMois = $maBDA->calculTotalCommandesParMois();
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
                        <h3>Page de commandes</h3>
                        <form id="search-form" class="d-flex recherche-admin" role="search">
                            <p>Recherche par : code PIN, code carte, entreprise, référence produit, nom produit, nom personne, prénom personne.</p>
                            <input id="search-input-commandes" class="form-control me-2" type="search" placeholder="..." aria-label="Search"></br>
                            <button class="btn btn-outline-success" style="width:50%;text-align:center;" type="submit">Rechercher</button>
                        </form>
                        <table class="table table-striped">
                            <thead id="table-head">
                                <tr>
                                    <th scope="col">Total commandes passées</th>
                                    <th scope="col">Total commandes passées ce mois-ci</th>
                                </tr>
                            </thead>
                                
                            <tbody id="table-body">
                                <tr>
                                    <td><?php echo $nbrTotalCommandes; ?></td>
                                    <td><?php echo $nbrTotalCommandesParMois; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </main>
                    <script src="../admin.js"></script>
                    <script>
                        performSearchProduit();
                    </script>
                </body>
            </html>