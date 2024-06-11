<?php 
session_start();
    $_SESSION = array();
    $_SESSION['user_actif'] = false;
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title> Connexion | Les chocolats du CSE </title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="Vues/design/styleindex1.css" />
        <link rel="icon" type="image/png" href="Vues/design/images/favicon-chocolats-cse.png">
        <link rel="preconnect" href="https://fonts.googleapis.com"> 
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;600;800&display=swap" rel="stylesheet">
        <!--<meta name="description" content="Page de connexion du site les chocolats du cse"/>-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    </head>
    <body>
        <main>
            <div class="divMain">
                <div class="hautPage">
                    <img class="imglogo" src="Vues/design/images/logo-accueil-chocolats-cse.png" alt="logo de l'entreprise">
                </div>
                <div class="milieuPage">
                    <h2> Merci de compléter les codes indiqués sur <br>
                        votre carte afin de choisir votre cadeau.</h2>
                </div>
                <div class="basPage">
                    <center><div id="boxConnexion">
                    
                        <form action="verif.php" method=POST>
        
                            <h3> Code carte</h3>
                            <input type=text name="codeC" placeholder="Code" maxlenght="50" required>
        
                            <h3> Code PIN </h3>
                            <input type="password" name="codeP" placeholder="PIN" minlength="8" maxlength="8" required>
        
                            <p id="boutonForm"> 
                                <input type=submit value=" > Connexion ">
                            </p>  
                        </form>
                    </div></center>
                </div>
            </div>
        </main>
    </body>
</html>