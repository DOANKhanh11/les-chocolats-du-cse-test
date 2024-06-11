<?php if (session_status() === PHP_SESSION_NONE) {
session_start(['cookie_lifetime'=>900,'cookie_secure'=>true,'cookie_httponly'=>true]);
}?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="../accueil-admin.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../gestion-pages-menu/commandes-admin.php">Commandes passées</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Produits</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../gestion-pages-menu/affichage-admin.php?param=produits">Affichage</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/creation-admin.php?param=produits">Création</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/modification-admin?info=produits">Modification</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Cartes</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../gestion-pages-menu/affichage-admin.php?param=cartes">Affichage</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/creation-admin.php?param=cartes">Création</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/modification-admin.php?info=cartes">Modification</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Entreprises</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../gestion-pages-menu/affichage-admin.php?param=entreprises">Affichage</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/creation-admin.php?param=entreprises">Création</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/modification-admin.php?info=entreprises">Modification</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Fournisseurs</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../gestion-pages-menu/affichage-admin.php?param=fournisseurs">Affichage</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/creation-admin.php?param=fournisseurs">Création</a></li>
            <li><a class="dropdown-item" href="../gestion-pages-menu/modification-admin.php?info=fournisseurs">Modification</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>