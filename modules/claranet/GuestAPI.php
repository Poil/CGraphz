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
		foreach($this->hierarchy as $prj){
			if($prj->id==$idPrj){
				foreach($prj->hosts as $host){
					$serversName[]=$host->name;
				}
				foreach($prj->wpm as $wpmName){
					$serversName[]=$wpmName;
				}
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
