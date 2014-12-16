<?php
	if(basename($_SERVER['PHP_SELF'])!=="index.php"){
		include_once('../../../config/config.php');	
	}
	if(isset($_GET['project']) && isset($_SESSION['hierarchy'])){
		$projects=json_decode($_SESSION["hierarchy"]);

		//Si le projet est -1 alors on affiche tous les serveurs
		if($_GET['project']=="-1"){
			$all=true;
		}else{
			$all=false;
		}
		echo '<option value="" ></option>';
		
		$endRequete="";
        foreach($projects as $project){
            if($all || $project->nom==$_GET['project']){
				if(isset($project->hosts)){
					foreach($project->hosts as $server){
						if($endRequete!="") $endRequete.=" OR ";
						$endRequete.="server_name LIKE '".$server->name."'";
					}
				}
				if(isset($project->wpm)){
					foreach($project->wpm as $name){
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
                $hName=$all_server[$i]->server_name;
                $selected="";
                if(isset($_GET['f_host']) && $_GET['f_host']==$hName) $selected="selected ";

                echo '<option '.$selected.'value="&f_host='.$hName.'&id_project='.$_GET['project'].'">'.$hName.'</option>';
            }
        }
	}
?>
