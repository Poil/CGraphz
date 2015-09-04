<?php
	include('../../../config/config.php');

	//La variable f_q contiendra la chaine de caractère de l'autocomplete.	
    $f_q="";
    if($_GET['f_q']){
        $f_q=$_GET['f_q'];
    }
	
    if($f_q!=""){
		//On recherche, dans la BDD de CGraphZ, les serveurs contenant la chaine de caractère de l'autocomplete. (trier par ordre alphabétique)
		$connSQL=new DB();
	    $requete="SELECT server_name
	              FROM config_server as server
				  WHERE server_name LIKE '%$f_q%'
				  ORDER BY server_name";
		$all_server=$connSQL->query($requete);
	
	    foreach($all_server as $server){
	        echo '<a href="'.DIR_WEBROOT.'/index.php?module=dashboard&amp;component=light&amp;f_host='.$server->server_name.'">'.$server->server_name.'</a><br />';
	    }
    }
?>
