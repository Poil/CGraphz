<?php
    // Cette appel ajax permet de savoir si la session est toujours active

	include('../../../config/config.php');
    if(!isset($_SESSION)){
        require "../../../modules/claranet/memcacheSessionHandler.class.php";
        session_start();
    }

    if(isset($_SESSION['user'])){
        echo "yes";
        exit();
    }else{
        echo "no";
        exit();
    }
?>
