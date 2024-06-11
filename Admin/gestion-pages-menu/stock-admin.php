<?php session_start(['cookie_lifetime'=>3600,'cookie_secure'=>true,'cookie_httponly'=>true]);?>
<?php if(!isset($_SESSION['admin']) || $_SESSION['admin']!='adminOK') {
    header('Location: ../../Admin');
    exit();
} ?>
<html lang="fr">
                <head>
                    <link rel="stylesheet" href="../admin.css" />
                    <meta charset="utf-8">
                    <link rel="icon" type="image/png" href="../../Vues/design/images/favicon-chocolats-cse.png">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">        <!-- Chargement des icons libres css du site font awesome https://fontawesome.com/start et https://fontawesome.com/icons?d=gallery&m=free-->
                    <!-- Inclusion des fichiers CSS de Bootstrap -->
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

                    <!-- Inclusion des scripts JavaScript de Bootstrap -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

                </head>
                <body>
                <!-- Navigation -->
                    <?php include_once('../pages-multiples/menu-admin.php'); ?>
                <!-- Main -->
                    <main>Main principal
                        <h3>Page de stock</h3>
                    </main>
                <!-- Footer -->
                    <footer>footer</footer>
                </body>
            </html>