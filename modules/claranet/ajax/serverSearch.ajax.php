<?php
	include('../../../config/config.php');
		
	//La variable f_q contiendra la chaine de caractère de l'autocomplete.
	$f_q="";
	if($_GET['f_q']){
		$f_q=$_GET['f_q'];
	}

	$endRequete="";

    //On recupère tous les serveurs, dans la variable de session "hierarchy", qu'on place dans un tableau pour pouvoir les trier par ordre alphabétique.
    if(isset($_SESSION["profile"]) && ($_SESSION["profile"]!="admin")){
        $projets=json_decode($_SESSION["hierarchy"]);
        foreach($projets as $projet){
            foreach($projet->hosts as $host){
                if(ereg(strtoupper($f_q),strtoupper($host->name))){
                    if($endRequete!="") $endRequete.=" OR ";
                    $endRequete.="server_name LIKE '".$host->name."'";
                }
            }
            foreach($projet->wpm as $name){
                if(ereg(strtoupper($f_q),strtoupper($name))){
                    if($endRequete!="") $endRequete.=" OR ";
                    $endRequete.="server_name LIKE '".$name."'";
                }
            }
        }
    }


    if($endRequete!=""){
        $connSQL=new DB();

        $requete="SELECT server_name FROM cgraphz.config_server where ".$endRequete." ORDER BY server_name";

        $all_server=$connSQL->query($requete);
        $cpt_server=count($all_server);

        for ($i=0; $i<$cpt_server; $i++) {
            $name=$all_server[$i]->server_name;

            echo '<a href="'.DIR_WEBROOT.'/index.php?module=dashboard&amp;component=light&amp;f_host='.$name.'">'.$name.'</a><br />';
        }
    }

?>
