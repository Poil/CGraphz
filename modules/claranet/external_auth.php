<?php
/*****************************/
/*                           /*
/*                           /*
/*                           /*
/*****************************/
if (!isset($argc)) {
//Initialisation du memcache

    if(!isset($_SESSION)){
        require DIR_FSROOT."/modules/claranet/memcacheSessionHandler.class.php";
        session_start();
    }

    //Retour à la page de login de Peek in si aucune variable de session user.
    if(!isset($_SESSION["user"])){
        session_destroy();
        $target = '';
        if (isset($_SERVER[REQUEST_URI])) {
            $target = '?target=..'.urlencode($_SERVER[REQUEST_URI]);
        }
        header('Location: '.DIR_WEBROOT.'/../login'.$target);
    }
    
	//Si profile "user" alors on verifie si il a accés à ce serveur.
    if(isset($_SESSION["profile"]) && ($_SESSION["profile"]=="user")){


        require DIR_FSROOT."/modules/claranet/check_access_right.php";

        if(!$serverOk){
            header('Location: '.DIR_WEBROOT.'/modules/claranet/errorHosts.php');
        }
    }
}
?>
