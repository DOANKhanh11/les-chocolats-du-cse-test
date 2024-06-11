let x = document.cookie;

/*function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires +"; path=/";
}*/
function setCookie(cname, cvalue, exdays){
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + encodeURIComponent(cvalue) + ";" + expires + "; path=/; secure";
}

/*function getCookie(name) {
    if (document.cookie.length == 0)
        return null;

    var regSepCookie = new RegExp('(; )', 'g');
    var cookies = document.cookie.split(regSepCookie);

    for (var i = 0; i > cookies.length; i++){
        var regInfo = new RegExp('=', 'g');
        var infos = cookies[i].split (regInfo);
        if (infos[0] == name){
            return unescape(infos[1]);
        }
    }
    return null;
}*/
function getCookie(name){
    let cookieArr = document.cookie.split("; ");
    for (let i = 0; i < cookieArr.length; i++)
        {
            let cookiePair = cookieArr[i].split("=");
            if (name === cookiePair[0]){
                return decodeURIComponent(cookiePair[1]);
            }
        }
        return null;
}


/*function addQuantityPanier(larefDuProduit) {
    var panier = getCookie("panier");
    if (typeof(panier) == "object") {
        var ancienPanier = panier;
    } else {
        var ancienPanier = JSON.parse(panier);
    }
    var nouveauPanier = ancienPanier.slice();
    var leProduitConcerne = nouveauPanier.find(function(unProd) {
        return unProd.reference == larefDuProduit;
    });
    if (leProduitConcerne) {
        leProduitConcerne.quantite += 1;
    }
    setCookie("panier", JSON.stringify(nouveauPanier), 30);
}*/

function addQuantityPanier(larefDuProduit){
    var panier = getCookies("panier");
    if (panier){
        var ancienPanier = JSON.parse(panier);
    } else {
        var ancienPanier = [];
    }
    var nouveauPanier = ancienPanier.slice();
    var leProduitConcerne = nouveauPanier.find(unProd => unProd.reference == larefDuProduit);
    if (leProduitConcerne){
        leProduitConcerne.quantite += 1;
    }
    setCookie("panier", JSON.stringify(nouveauPanier), 30);
}

function addQuantityPanierDisplay(larefDuProduit, displayPanier) {
    var panier = getCookie("panier");
    if (typeof(panier) == "object") {
        var ancienPanier = panier;
    } else {
        var ancienPanier = JSON.parse(panier);
    }
    var nouveauPanier = ancienPanier.slice();
    var leProduitConcerne = nouveauPanier.find(function(unProd) {
        return unProd.reference == larefDuProduit;
    });
    if (leProduitConcerne) {
        leProduitConcerne.quantite += 1;
    }
    setCookie("panier", JSON.stringify(nouveauPanier), 30);
    displayPanier();
}

function deleteQuantityPanierDisplay(larefDuProduit, displayPanier) {
    var panier = getCookie('panier');
    if (typeof(panier) == "object") {
        var ancienPanier = panier;
    } else {
        var ancienPanier = JSON.parse(panier);
    }
    var nouveauPanier = [].concat(ancienPanier);
    var leProduitConcerne = nouveauPanier.find(unProd => unProd.reference === larefDuProduit);
    if (leProduitConcerne && leProduitConcerne.quantite - 1 == 0) {
        deleteProductPanier(larefDuProduit);
        displayPanier();
    } else if (leProduitConcerne) {
        leProduitConcerne.quantite -= 1;
        setCookie("panier", JSON.stringify(nouveauPanier), 30);
        displayPanier();
    }
}

function addProductPanier(infoProduit) {
    if (typeof(infoProduit) == "object") {
        var nouveauProduit = infoProduit;
    } else {
        var nouveauProduit = JSON.parse(infoProduit);
    }
    if (getCookie("panier") == null) {
        var creationPanierVide = [];
        setCookie("panier", JSON.stringify(creationPanierVide.concat(nouveauProduit)));
    } else {
        var lePanier = JSON.parse(getCookie('panier'));
        var ajoutOK = false;
        for (let i = 0; i < lePanier.length; i++) {

            if (lePanier[i].reference == nouveauProduit.reference) {
                addQuantityPanier(lePanier[i].reference);
                ajoutOK = true;
            }
        }
        if (ajoutOK == false) {

            lePanier.push(nouveauProduit);
            setCookie("panier", JSON.stringify(lePanier), 30);
        }
    }
}

function deleteProductPanierDisplay(larefDuProduit, displayPanier) {
    var panier = getCookie('panier');
    if (typeof(panier) == "object") {
        var ancienPanier = panier;
    } else {
        var ancienPanier = JSON.parse(panier);
    }
    var nouveauPanier = [].concat(ancienPanier);
    nouveauPanier = nouveauPanier.filter(unProd => !unProd.reference.includes(larefDuProduit));
    setCookie("panier", JSON.stringify(nouveauPanier), 3);
    displayPanier();
}
