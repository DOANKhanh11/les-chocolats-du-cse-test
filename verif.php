<?php session_start(['cookie_lifetime'=>3600,'cookie_secure'=>true ,'cookie_httponly'=>true]);
if(!isset($_POST['codeC']) && (!isset( $_POST['codeP'])));
{
  //header('Location: index.php');
} 
?>
<?php 
include_once('Outil/accesBD.php');
$maBD=null;
$retour=null;
$maBD=new accesBD();
$maBD->connexion();

if($_SESSION['user_actif']==false)
{
    
    $codecarte = $_POST['codeC'];
    $codepin = $_POST['codeP'];

    $retour = $maBD->verifExistanceCarte($codecarte,$codepin);

    if ($retour==0)
    { 
        header('Location: index.php');
    } 
    if ($retour==1) 
    {
        // $panierVide = array();
        // $panierJson = json_encode($panierVide);
        $_SESSION['codecarte'] = $codecarte;
        $_SESSION['codepin'] = $codepin;
        $_SESSION['user_actif']=true;
    }
}
if($_SESSION['user_actif']==true)
{
    $_SESSION['descriptionEntreprise'] = $maBD->infoCarteDescription($_SESSION['codecarte']);
    $_SESSION['nbrPointCarte'] = $maBD->infoCartePoint($_SESSION['codepin']);
    if (intval($_SESSION['nbrPointCarte']) > 0) {
        $_SESSION['carteValide'] = 'actif';
    }
    $infoUser = array(
        'carte' => strip_tags($_SESSION['codecarte']),
        'pin' => strip_tags($_SESSION['codepin']),
        'pointInitial' => strip_tags($_SESSION['nbrPointCarte']),
        'pointDispo' => strip_tags($_SESSION['nbrPointCarte'])
    );
    $infoUserJson = json_encode($infoUser);
    setcookie('utilisateur',$infoUserJson,time()+(3600*24*7),'/','',true,false); 
    setcookie('panier','[]',time()+(3600*24*7),'/','',true,false); 
    header('Location: Vues/ihm/accueil.php');
}
?>