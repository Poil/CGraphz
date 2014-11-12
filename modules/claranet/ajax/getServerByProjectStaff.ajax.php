<?php
	include('../../../config/config.php');
	$connSQL=new DB();
    if(isset($_GET['project'])){
		//Récuperation des serveurs d'un projet dans claratact
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, "http://claratact.fr.clara.net/REST/Projet/getProjectHosts.php");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);

        $postfields=array('login'=>'FR-Claratact-API','pass'=>'phax5d!idhj8h','idProjet'=>$_GET['project']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

		$return=curl_exec($curl);

        curl_close($curl);
        $return=json_decode($return);

		echo '<option value=""></option>';
		
		$endRequete="";
        foreach($return->hosts as $server){
			if($endRequete!="") $endRequete.=" OR ";
			$endRequete.="server_name LIKE '".$server->name."'";
        }
        foreach($return->wpm as $wpmName){
			if($endRequete!="") $endRequete.=" OR ";
            $endRequete.="server_name LIKE '".$wpmName."'";
        }
	
		if($endRequete!=""){	
			$connSQL=new DB();

			$requete="SELECT server_name FROM cgraphz.config_server where ".$endRequete." ORDER BY server_name";

		    $all_server=$connSQL->query($requete);
			$cpt_server=count($all_server);

			for ($i=0; $i<$cpt_server; $i++) {
				$hName=$all_server[$i]->server_name;
				$selected="";
				if(isset($_GET['f_host']) && $_GET['f_host']==$hName) $selected="selected ";
				
				echo '<option '.$selected.'value="&f_host='.$hName.'&id_project='.$_GET['project'].'">'.$hName.'</option>';
			}
		}

    }
?>

