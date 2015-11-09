<?php
	// Ce script AJAX permet la mise a jour de l'input Search pour un client	

	include('../../../config/config.php');

    //La variable f_q contiendra la chaine de caractère de l'autocomplete.
    $f_q="";
    if($_GET['f_q']){
        $f_q=$_GET['f_q'];
    }

    //On recupère tous les serveurs, dans la variable de session "hierarchy", qu'on place dans un tableau pour pouvoir les trier par ordre alphabétique.
    $tabNomSearch=array();
    if(isset($_SESSION["profile"]) && ($_SESSION["profile"]!="admin")){
        $projets=json_decode($_SESSION["hierarchy"]);
        foreach($projets as $projet){
            foreach($projet->hosts as $host){
                if(ereg(strtoupper($f_q),strtoupper($host->name))){
                    $tabNomSearch[]=$host->name;
                }
            }
            foreach($projet->wpm as $name){
                if(ereg(strtoupper($f_q),strtoupper($name))){
                    $tabNomSearch[]=$name;
                }
            }
        }
    }
    //Trie des noms de serveurs par ordre alphabétique
    natcasesort($tabNomSearch);
    foreach($tabNomSearch as $name){
        echo '<a href="'.DIR_WEBROOT.'/index.php?module=dashboard&amp;component=light&amp;f_host='.$name.'">'.$name.'</a><br />';
    }

?>
