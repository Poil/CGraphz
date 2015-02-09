<?php

class GuestAPI{

	private $hierarchy=null;
	
	public function __construct(){
		if(isset($_SESSION['hierarchy'])){
			$this->hierarchy=json_decode($_SESSION['hierarchy']);
		}else{
			$this->hierarchy=array();
		}
	}

	public function getIdProjetFromHostname($hostname){
		foreach($this->hierarchy as $prj){
			foreach($prj->hosts as $host){
				if($hostname==$host->name){
					return $prj->id;
				}
			}
			foreach($prj->wpm as $wpmName){
                if($hostname==$wpmName){
                    return $prj->id;
                }
            }
		}
		return -1;
	}

	public function getServers($idPrj){
		$serversName=array();
		$endRequete="";
        foreach($this->hierarchy as $project){
            if($project->id==$idPrj){
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

            $requete="SELECT server_name FROM cgraphz.config_server where ".$endRequete."
					ORDER BY CASE
						WHEN server_name like 'WEB%' THEN concat(2,server_name)
						ELSE concat(1,server_name)
					END";

            $all_server=$connSQL->query($requete);
            $cpt_server=count($all_server);

            for ($i=0; $i<$cpt_server; $i++) {
                $serversName[]=$all_server[$i]->server_name;
            }
        }
	
		return $serversName;
	}

	public function getAllServers(){
		$serversName=array();
        foreach($this->hierarchy as $prj){
            foreach($prj->hosts as $host){
                $serversName[]=$host->name;
            }
            foreach($prj->wpm as $wpmName){
                $serversName[]=$wpmName;
            }
        }
        return $serversName;

	}
}

?>
