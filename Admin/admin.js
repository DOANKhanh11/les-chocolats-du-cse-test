/* ================================================================================ */
/* ========= Formulaire de recherche dans affichage et commandes passées ========== */
/* ================================================================================ */
// Sélection de l'icône de recherche et de la barre de recherche 
var searchIcon = document.getElementById('search-icon');
var searchForm = document.querySelector('.recherche-admin');
// Gestionnaire d'évenement pour le clic sur l'icône de recherche 
searchIcon.addEventListener('click', function() {
    searchForm.classList.toggle('show');
});
/* ================================================================================ */
/* ================= Traitement champs de recherche des produits ================== */
/* ================================================================================ */
function performSearchProduit() {
    var searchFormRecherche = document.getElementById('search-form');
    if (document.getElementById('search-input-produits') !== null) {
        var searchInput = document.getElementById('search-input-produits');
        var type = 'produit';
    }
    if (document.getElementById('search-input-cartes') !== null) {
        var searchInput = document.getElementById('search-input-cartes');
        var type = 'carte';
    }
    if (document.getElementById('search-input-entreprises') !== null) {
        var searchInput = document.getElementById('search-input-entreprises');
        var type = 'entreprise';
    }
    if (document.getElementById('search-input-fournisseurs') !== null) {
        var searchInput = document.getElementById('search-input-fournisseurs');
        var type = 'fournisseur';
    }
    if (document.getElementById('search-input-commandes') !== null) {
        var searchInput = document.getElementById('search-input-commandes');
        var type = 'commande';
    }

    searchFormRecherche.addEventListener('submit', function(event) {
        event.preventDefault();
        var searchTerm = searchInput.value;
        fetch('../recherche.php?search=' + searchTerm + '&type=' + type)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                //Traiter les résultats de recherche 
                console.info("Variable data " + data);
                if (data[0]['type'] === 'produit') {
                    generateTableContentProduct(data);
                } else if (data[0]['type'] === 'carte') {
                    generateTableContentCard(data);
                } else if (data[0]['type'] === 'entreprise') {
                    generateTableContentCompany(data);
                } else if (data[0]['type'] === 'fournisseur') {
                    generateTableContentSupplier(data);
                } else if (data[0]['type'] === 'commande') {
                    generateTableContentOrder(data);
                }
            })
            .catch(function(error) {
                console.error('Erreur de requête AJAX :', error);
            });
    });
}
/* ================================================================================ */
/* ============ Création du tableau de réponse pour recherche produit  ============ */
/* ================================================================================ */
function generateTableContentProduct(results) {
    var tableHead = document.getElementById('table-head');
    var tableBody = document.getElementById('table-body');
    var displaySearchTotal = document.getElementById('p-nbr-resultat');

    // Vider le contenu actuel des éléments 
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';
    displaySearchTotal.innerHTML = '';

    // Générer le nombre total de produits récupérés
    displaySearchTotal.innerHTML = '<p><strong>' + results.length + ' produits trouvés.</strong></p>';

    // Générer la section <thead> du tableau 
    var tableHeadContent = '<tr>' +
        '<th scope="col">Modif</th>' +
        '<th scope="col">Référence</th>' +
        '<th scope="col">Nom</th>' +
        '<th scope="col">Stock</th>' +
        '<th scope="col">Statut</th>' +
        '<th scope="col">Point</th>' +
        '<th scope="col">Fournisseur</th>' +
        '</tr>';
    tableHead.innerHTML = tableHeadContent;
    // Parcourir les résultats et générer les lignes du tableau 
    for (var i = 0; i < results.length; i++) {
        var result = results[i];
        var id = result.id;
        var reference = result.reference;
        var nom = result.nom;
        var stock = result.stock;
        if (result.statut == 1) {
            var statut = 'actif';
        } else {
            var statut = 'inactif';
        }
        var point = result.point;
        var fournisseur = result.fournisseur;

        // générer une ligne du tableau avec les données 
        var row = '<tr>' +
            '<td><a href="modification-admin.php?table=produit&id=' + id + '&reference=' + reference + '"><img src="../icon-modify.png"/></a></td>' +
            '<th scope="row">' + reference + '</th>' +
            '<td>' + nom + '</td>' +
            '<td>' + stock + '</td>' +
            '<td>' + statut + '</td>' +
            '<td>' + point + '</td>' +
            '<td>' + fournisseur + '</td>' +
            '</tr>';

        // Ajouter la ligne au corps du tableau
        tableBody.innerHTML += row;
    }
}
/* ================================================================================ */
/* ============= Création du tableau de réponse pour recherche carte  ============= */
/* ================================================================================ */
function generateTableContentCard(results) {
    var tableHead = document.getElementById('table-head');
    var tableBody = document.getElementById('table-body');
    var displaySearchTotal = document.getElementById('p-nbr-resultat');

    // Vider le contenu actuel des éléments 
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';
    displaySearchTotal.innerHTML = '';

    // Générer le nombre total de produits récupérés
    displaySearchTotal.innerHTML = '<p><strong>' + results.length + ' cartes trouvées.</strong></p>';

    // Générer la section <thead> du tableau 
    var tableHeadContent = '<tr>' +
        '<th scope="col">Modif</th>' +
        '<th scope="col">Code PIN</th>' +
        '<th scope="col">Code carte</th>' +
        '<th scope="col">Point restant</th>' +
        '<th scope="col">Statut</th>' +
        '<th scope="col">Entreprise</th>' +
        '</tr>';
    tableHead.innerHTML = tableHeadContent;
    // Parcourir les résultats et générer les lignes du tableau 
    for (var i = 0; i < results.length; i++) {
        var result = results[i];
        var id = result.id;
        var codeCarte = result.codeCarte;
        var codePin = result.codePin;
        var point = result.point;
        if (result.statut == 1) {
            var statut = 'actif';
        } else {
            var statut = 'inactif';
        }
        var entreprise = result.entreprise;

        // générer une ligne du tableau avec les données 
        var row = '<tr>' +
            '<td><a href="modification-admin.php?table=carte&id=' + id + '&reference=' + codePin + '"><img src="../icon-modify.png"/></a></td>' +
            '<th scope="row">' + codePin + '</th>' +
            '<td>' + codeCarte + '</td>' +
            '<td>' + point + '</td>' +
            '<td>' + statut + '</td>' +
            '<td>' + entreprise + '</td>' +
            '</tr>';

        // Ajouter la ligne au corps du tableau
        tableBody.innerHTML += row;
    }
}
/* ================================================================================ */
/* ========== Création du tableau de réponse pour recherche entreprise  =========== */
/* ================================================================================ */
function generateTableContentCompany(results) {
    var tableHead = document.getElementById('table-head');
    var tableBody = document.getElementById('table-body');
    var displaySearchTotal = document.getElementById('p-nbr-resultat');

    // Vider le contenu actuel des éléments 
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';
    displaySearchTotal.innerHTML = '';

    // Générer le nombre total de produits récupérés
    displaySearchTotal.innerHTML = '<p><strong>' + results.length + ' entreprises trouvées.</strong></p>';

    // Générer la section <thead> du tableau 
    var tableHeadContent = '<tr>' +
        '<th scope="col">Modif</th>' +
        '<th scope="col">Nom</th>' +
        '<th scope="col">Date de création</th>' +
        '<th scope="col">Point initial</th>' +
        '<th scope="col">Statut</th>' +
        '</tr>';
    tableHead.innerHTML = tableHeadContent;

    for (var i = 0; i < results.length; i++) {
        var result = results[i];
        var id = result.id;
        var dateCrea = result.dateCrea;
        var nom = result.nom;
        var point = result.point;
        var statut = result.statut;

        // générer une ligne du tableau avec les données 
        var row = '<tr>' +
            '<td><a href="modification-admin.php?table=entreprise&id=' + id + '&reference= ' + nom + '"><img src="../icon-modify.png"/></a></td>' +
            '<th scope="row">' + nom + '</th>' +
            '<td>' + dateCrea + '</td>' +
            '<td>' + point + '</td>' +
            '<td>' + statut + '</td>' +
            '</tr>';

        // Ajouter la ligne au corps du tableau
        tableBody.innerHTML += row;
    }
}
/* ================================================================================ */
/* ========= Création du tableau de réponse pour recherche fournisseur  =========== */
/* ================================================================================ */
function generateTableContentSupplier(results) {
    var tableHead = document.getElementById('table-head');
    var tableBody = document.getElementById('table-body');
    var displaySearchTotal = document.getElementById('p-nbr-resultat');

    // Vider le contenu actuel des éléments 
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';
    displaySearchTotal.innerHTML = '';

    // Générer le nombre total de produits récupérés
    displaySearchTotal.innerHTML = '<p><strong>' + results.length + ' fournisseurs trouvés.</strong></p>';

    // Générer la section <thead> du tableau 
    var tableHeadContent = '<tr>' +
        '<th scope="col">Modif</th>' +
        '<th scope="col">Nom</th>' +
        '<th scope="col">Date de création</th>' +
        '<th scope="col">Mail</th>' +
        '<th scope="col">Quantité de produits fournis</th>' +
        '</tr>';
    tableHead.innerHTML = tableHeadContent;
    // Parcourir les résultats et générer les lignes du tableau 
    for (var i = 0; i < results.length; i++) {
        var result = results[i];
        var id = result.id;
        var nom = result.nom;
        var dateCrea = result.dateCrea;
        var mail = result.mail;
        var nbrProduitFournis = result.nbrProduitFournis;

        // générer une ligne du tableau avec les données 
        var row = '<tr>' +
            '<td><a href="modification-admin.php?table=fournisseur&id=' + id + '&reference=' + nom + '"><img src="../icon-modify.png"/></a></td>' +
            '<th scope="row">' + nom + '</th>' +
            '<td>' + dateCrea + '</td>' +
            '<td>' + mail + '</td>' +
            '<td>' + nbrProduitFournis + '</td>' +
            '</tr>';

        // Ajouter la ligne au corps du tableau
        tableBody.innerHTML += row;
    }
}
/* ================================================================================ */
/* =========== Création du tableau de réponse pour recherche commande  ============ */
/* ================================================================================ */
function generateTableContentOrder(results) {
    var tableHead = document.getElementById('table-head');
    var tableBody = document.getElementById('table-body');
    var displaySearchTotal = document.getElementById('p-nbr-resultat');

    // Vider le contenu actuel des éléments 
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';
    displaySearchTotal.innerHTML = '';

    // Générer le nombre total de produits récupérés
    displaySearchTotal.innerHTML = '<p><strong>' + results.length + ' commandes trouvées.</strong></p>';

    // Générer la section <thead> du tableau 
    var tableHeadContent = '<tr>' +
        '<th scope="col">Modif</th>' +
        '<th scope="col">Date commande</th>' +
        '<th scope="col">Code Pin</th>' +
        '<th scope="col">Code carte</th>' +
        '<th scope="col">Entreprise</th>' +
        '<th scope="col">Nom Personne</th>' +
        '<th scope="col">Prénom personne</th>' +
        '<th scope="col">Référence produit</th>' +
        '<th scope="col">Nom produit</th>' +
        '<th scope="col">Quantité produit</th>' +
        '</tr>';
    tableHead.innerHTML = tableHeadContent;
    // Parcourir les résultats et générer les lignes du tableau 
    for (var i = 0; i < results.length; i++) {
        var result = results[i];
        var id = result.id;
        var dateCommande = result.dateCommande;
        var codePin = result.codePin;
        var codeCarte = result.codeCarte;
        var nomEntreprise = result.nomEntreprise;
        var nomPersonne = result.nomPersonne;
        var prenomPersonne = result.prenomPersonne;
        var tableauPanier = result.tableauPanier;
        var referenceProduit = result.tableauPanier.referenceProduit;
        var nomProduit = result.tableauPanier.nomProduit;
        var quantite = result.tableauPanier.quantite;

        // générer une ligne du tableau avec les données 
        var row = '<tr>' +
            '<td><a href="#"><img src="../icon-modify.png"/></a></td>' +
            '<td>' + dateCommande + '</td>' +
            '<th scope="row">' + codePin + '</th>' +
            '<td>' + codeCarte + '</td>' +
            '<td>' + nomEntreprise + '</td>' +
            '<td>' + nomPersonne + '</td>' +
            '<td>' + prenomPersonne + '</td>' +
            '<td>' + referenceProduit + '</td>' +
            '<td>' + nomProduit + '</td>' +
            '<td>' + quantite + '</td>' +
            '</tr>';
        // Ajouter la ligne au corps du tableau
        tableBody.innerHTML += row;
    }
}