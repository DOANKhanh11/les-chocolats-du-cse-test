<?php 
session_start();
    $formatageDate = date('d').'/'.date('m').'/'.date('y').'/';
    $cookieRGPD = array(
        'identifiant' => strip_tags($_SESSION['codepin']),
        'dateAcceptation' => $formatageDate,
        'accepteCookies' => 'yes'
    );
    setcookie('www.les-chocolats-du-cse.test',json_encode($cookieRGPD),time()+(3600*24*30),'/','',true,false);
    $_SESSION['acceptcookie'] = json_encode($cookieRGPD);
    echo $_SESSION['acceptcookie'];
?>