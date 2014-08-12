<?php
	//Récupère les serveurs classé par projet, ainsi que le nom du projet en cours.
	
	//Contiendra le nom du projet en cours.
	$nameProject="";
	//Contiendra l'ensemble des serveurs, authorisé pour cette utilisateur, classé par projet.
	$tabHosts=array();
	if(isset($_SESSION["profile"]) && ($_SESSION["profile"]=="user")){
		//L'ensemble des serveurs authorisé est contenu dans la variable de session "hierarchy".
		$hier_decode=json_decode($_SESSION["hierarchy"]);
		foreach($hier_decode as $projet){
			$tabHosts[$projet->nom]=array();
			foreach($projet->hosts as $host){
				if(isset($_GET['f_host']) && $_GET['f_host']==$host->name){
					$nameProject=$projet->nom;
				}
				$tabHosts[$projet->nom][]=$host->name;
				$i++;
			}
			foreach($projet->wpm as $name){
				if(isset($_GET['f_host']) && $_GET['f_host']==$name){
                    $nameProject=$projet->nom;
                }
				$tabHosts[$projet->nom][]=$name;
				$i++;
			}
		}
	}else if(isset($_SESSION["profile"])){
		if(isset($_GET["id_project"])){
			$nameProject=$_GET["id_project"];
		}
	}	
?>
