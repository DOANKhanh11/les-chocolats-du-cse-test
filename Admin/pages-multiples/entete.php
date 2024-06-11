<!DOCTYPE html>
<html lang="fr">
    <head>
        <title> Accueil | Les chocolats du CSE </title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../design/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">        <!-- Chargement des icons libres css du site font awesome https://fontawesome.com/start et https://fontawesome.com/icons?d=gallery&m=free-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="icon" type="image/png" href="../design/images/favicon-chocolats-cse.png">
        <link rel="preconnect" href="https://fonts.googleapis.com"> 
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;600;800&display=swap" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
       
    </head>
    <body>
        <header><div id="divHeader">
        <div id="headerGauche">
            <img class="imglogo" src="../design/images/logo-JCSE.png" alt="logo de l\'entreprise">
        </div>
        <div id="headerCentre">
            <p>Page administrateur</p>
        </div>
        <div id="headerDroit">
            <?php include_once('menu-admin.php');?>
        </div>
        </div>
    </header>
    </body>