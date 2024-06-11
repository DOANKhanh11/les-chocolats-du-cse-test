<?php session_start(['cookie_lifetime'=>900,'cookie_secure'=>true,'cookie_httponly'=>true]);?>
<?php 
  if (isset($_POST['cle']) || isset($_SESSION['admin'])=='adminOK') {
    include_once('accesBDA.php');
    $maBD = new accesBDA();
    if (isset($_POST['cle'])) {
        $connexionAdmin = $maBD->verifCle($_POST['cle']);
        $_SESSION['admin']='adminOK';
    }
    elseif (isset($_SESSION['admin'])=='adminOK') {
        $connexionAdmin='accepte';
    }
    else {
        echo "Erreur de connexion";
    }

    if ($connexionAdmin=='accepte') {
        // Connexion réussite 
        try {
        ?>
            <html lang="fr">
                <head>
                    <link rel="stylesheet" href="admin.css" />
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
      <!-- <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Code PIN" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Rechercher</button>
      </form> -->
    </div>
  </div>
</nav>
                <!-- Header -->
                <!-- Main -->
                    <main>
                        </br>
                        <img class="imglogoadmin" src="../Vues/design/images/logo-JCSE.png" alt="logo de l'entreprise">
                        <h3>Les chocolats du CSE</h3>
                        <?php if (session_status() === PHP_SESSION_NONE) {
                    session_start(['cookie_lifetime'=>900,'cookie_secure'=>true,'cookie_httponly'=>true]);
                  }?>
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                  <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                      <div class="container-fluid">
                        <a class="navbar-brand" href="../accueil-admin.php">
                            Accueil
                        </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="gestion-pages-menu/commandes-admin.php">Commandes passées</a>
                      </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Produits</a>
                        <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="gestion-pages-menu/affichage-admin.php?param=produits">Affichage</a></li>
                      <li><a class="dropdown-item" href="gestion-pages-menu/creation-admin.php?param=produits">Création</a></li>
                      <li><a class="dropdown-item" href="gestion-pages-menu/modification-admin.php?table=produit&id=?&reference=?">Modification</a></li>
                    </ul>
                      </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Cartes</a>
                        <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="gestion-pages-menu/affichage-admin.php?param=cartes">Affichage</a></li>
                      <li><a class="dropdown-item" href="gestion-pages-menu/creation-admin.php?param=cartes">Création</a></li>
                      <li><a class="dropdown-item" href="gestion-pages-menu/modification-admin.php?table=carte&id=?&reference=?">Modification</a></li>
                    </ul>
                    </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Entreprises</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="gestion-pages-menu/affichage-admin.php?param=entreprises">Affichage</a></li>
            <li><a class="dropdown-item" href="gestion-pages-menu/creation-admin.php?param=entreprises">Création</a></li>
            <li><a class="dropdown-item" href="gestion-pages-menu/modification-admin.php?table=entreprise&id=?&reference=?">Modification</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Fournisseurs</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="gestion-pages-menu/affichage-admin.php?param=fournisseurs">Affichage</a></li>
            <li><a class="dropdown-item" href="gestion-pages-menu/creation-admin.php?param=fournisseurs">Création</a></li>
            <li><a class="dropdown-item" href="gestion-pages-menu/modification-admin.php?table=fournisseur&id=?reference=?">Modification</a></li>
          </ul>
        </li>
      </ul>
                    </main>
                <!-- Footer -->
                    <footer></footer>
                </body>
            </html>
        <?php         
        }
        catch(PDOException $e) {
            die('Erreur de connexion');
        }
        // Fin connexion réussite 
    }
    else {
        header('Location: index.php');
    }
}
else {
    header('Location: index.php');
}
?>