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
		$allHosts=array();
        foreach($return->hosts as $server){
			$allHosts[]=$server->name;
        }
        foreach($return->wpm as $wpmName){
			$allHosts[]=$wpmName;
        }
		asort($allHosts);
		foreach($allHosts as $hName){
			echo '<option value="&f_host='.$hName.'&id_project='.$_GET['project'].'">'.$hName.'</option>';
		}

    }
?>

