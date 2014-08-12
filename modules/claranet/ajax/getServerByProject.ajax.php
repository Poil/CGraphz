<?php
	include('../../../config/config.php');	

	if(isset($_GET['project']) && isset($_SESSION['hierarchy'])){
		$projects=json_decode($_SESSION["hierarchy"]);

		//Si le projet est -1 alors on affiche tous les serveurs
		if($_GET['project']=="-1"){
			$all=true;
		}else{
			$all=false;
		}
		echo '<option value="" ></option>';

		//Pour la cas ou on affiche tous les serveurs, on regroupe tous les noms dans un tableau pour réaliser un tri par ordre alphabétique.
		$allNameServer=array();
		foreach($projects as $project){
            if($all || $project->nom==$_GET['project']){
                foreach($project->hosts as $server){
                    if($all){
						$allNameServer[]=$server->name;
					}else{
						echo '<option value="&f_host='.$server->name.'" >'.$server->name.'</option>';
					}
				}
                foreach($project->wpm as $name){
					if($all){
                        $allNameServer[]=$name;
                    }else{
						echo '<option value="&f_host='.$name.'" >'.$name.'</option>';
					}
                }
            }
        }

		//Réalisation du tri alphabétique lorsque l'on affiche tous les serveurs.
        if($all){
            natcasesort($allNameServer);
            foreach($allNameServer as $server_name){
				echo '<option value="&f_host='.$server_name.'">'.$server_name.'</option>';
			}
		}
	}
?>
