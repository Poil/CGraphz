<?php
require_once(DIR_FSROOT.'/modules/claranet/ClaratactClient.php');
require_once(DIR_FSROOT.'/modules/claranet/GuestAPI.php');
require_once(DIR_FSROOT.'/modules/preg_find.php');
require_once(DIR_FSROOT.'/modules/DB.php');
require_once(DIR_FSROOT.'/modules/functions.inc.php');

class Compare{

	public $claratactClt=null;
	public $config=null;
	public $s_id_user=null;
	public $guestAPI=null;

	private $profile=null;

	public function __construct($config){
		$this->claratactClt=new ClaratactClient();	
		$this->guestAPI=new GuestAPI();
		$this->config=$config;

		$this->s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

		if(isset($_SESSION['profile'])) $this->profile=$_SESSION['profile'];
		else $this->profile="user";
	}

	public function getIdPrjFromHostname($hostname){
		if($this->profile=="admin" || $this->profile=="staff"){
			return $this->claratactClt->getIdPrjFromHostname($hostname);
		}else{
			return $this->guestAPI->getIdProjetFromHostname($hostname);
		}
	}

	public function getFilter(){
		$lib = 'SELECT
			        cpf.*
			    FROM
			        config_plugin_filter cpf
			        LEFT JOIN config_plugin_filter_group cpfg
			            ON cpf.id_config_plugin_filter=cpfg.id_config_plugin_filter
			        LEFT JOIN auth_group ag
			            ON cpfg.id_auth_group=ag.id_auth_group
			        LEFT JOIN auth_user_group aug
			            ON aug.id_auth_group=ag.id_auth_group
			    WHERE
			        aug.id_auth_user=:s_id_user
			    ORDER BY plugin_order, plugin, plugin_instance, type, type_instance';
		$connSQL=new DB();
		$connSQL->bind('s_id_user',$this->s_id_user);
		return $connSQL->query($lib);	
	}
	
	public function getPlugins($id_prj){
		$serverNames=$this->getServeur($id_prj);
		
		$plugin_array=array();

		$pg_filters=$this->getFilter();
		foreach($serverNames as $serverName){
			if (is_dir($this->config['datadir'].'/'.$serverName.'/')) {
				 $myregex='';
                foreach ($pg_filters as $filter) {
                    if (empty($myregex)) {
                        $myregex='#^((('.$this->config['datadir'].'/'.$serverName.'/)('.$filter->plugin.')(?:\-('.$filter->plugin_instance.'))?/('.$filter->type.')(?:\-('.$filter->type_instance.'))?\.rrd)';
                    } else {
                        $myregex=$myregex.'|(('.$this->config['datadir'].'/'.$serverName.'/)('.$filter->plugin.')(?:\-('.$filter->plugin_instance.'))?/('.$filter->type.')(?:\-('.$filter->type_instance.'))?\.rrd)';
                    }
                }

                $myregex=$myregex.')#';

                $plugins = preg_find($myregex, $this->config['datadir']."/".$serverName, PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH|PREG_FIND_SORTBASENAME);

                $myregex='#^('.$this->config['datadir'].'/'.$serverName.'/)(\w+)(?:\-(.*))?/(\w+)(?:\-(.*))?\.rrd#';

				

				foreach ($plugins as $plugin) {
                    preg_match($myregex, $plugin, $matches);
                    
					if (isset($matches[2])) {
                       $p=$matches[2];
                    } else {
                       $p=null;
                    }
                    if (!is_blank($matches[3])) {
                       $pi=$matches[3];
                       $pc=null;
                       if (substr_count($pi, '-') >= 1 && preg_match($this->config['plugin_pcategory'], $p)) {
                          $tmp=explode('-',$pi);
                          $pc=$tmp[0];
                          $pi=implode('-',array_slice($tmp,1));
                       } else if (preg_match($this->config['plugin_pcategory'], $p)) {
                          $pc=$pi;
                          $pi=null;
                       }
                    } else {
                       $pc=null;
                       $pi=null;
                    }
                    if (isset($matches[4])) {
                       $t=$matches[4];
                    } else {
                       $t=null;
                    }
                    if (isset($matches[5]) && !is_blank($matches[5])) {
                       $ti=$matches[5];
                       $tc=null;
                       if (substr_count($ti, '-') >= 1 && preg_match($this->config['plugin_tcategory'], $p)) {
                          $tmp=explode('-',$ti);
                          $tc=$tmp[0];
                          $ti=null;
                       }
					} else {
                       $tc=null;
                       $ti=null;
                    }


					if($p!==null){

                        if($pc===null || $pc==="")$pc="null";
                        if($pi===null || $pi==="")$pi="null";
                        if($t===null || $t==="")$t="null";
                        if($tc===null || $tc==="")$tc="null";
                        if($ti===null || $ti==="")$ti="null";
	
						
						$plugin_array=$this->createArchiPlugin($plugin_array,$p);
	
						$plugin_array[$p]=$this->createArchiPlugin($plugin_array[$p],$pc);
	                    $plugin_array[$p][$pc]=$this->createArchiPlugin($plugin_array[$p][$pc],$pi);
	                    $plugin_array[$p][$pc][$pi]=$this->createArchiPlugin($plugin_array[$p][$pc][$pi],$t);
	                    $plugin_array[$p][$pc][$pi][$t]=$this->createArchiPlugin($plugin_array[$p][$pc][$pi][$t],$tc);
	
	                    $plugin_array[$p][$pc][$pi][$t][$tc]=$ti;
					}
				}
			}
		}
		return $plugin_array;
	}


	


	public function getServeur($id_prj){
		if($this->profile=="admin" || $this->profile=="staff"){
			$servers=$this->claratactClt->getServeurForProject($id_prj);
	
			$serverNames=array();
	
			$endRequete="";
	        foreach($servers->hosts as $server){
	            if($endRequete!="") $endRequete.=" OR ";
	            $endRequete.="server_name LIKE '".$server->name."'";
	        }
	        foreach($servers->wpm as $wpmName){
	            if($endRequete!="") $endRequete.=" OR ";
	            $endRequete.="server_name LIKE '".$wpmName."'";
	        }
	
	        if($endRequete!=""){
	            $connSQL=new DB();
	
	            $requete="SELECT server_name FROM cgraphz.config_server where ".$endRequete." ORDER BY server_name";
	
	            $all_server=$connSQL->query($requete);
	            $cpt_server=count($all_server);
	
	            for ($i=0; $i<$cpt_server; $i++) {
	                $serverNames[]=$all_server[$i]->server_name;
	            }
	        }
		}else{
			$serverNames=$this->guestAPI->getServers($id_prj);
		}	
		return $serverNames;
	}

	public function getAllServers(){
		if($this->profile=="admin" || $this->profile=="staff"){
            $serverNames=array();

            $connSQL=new DB();

            $requete="SELECT server_name FROM cgraphz.config_server ORDER BY server_name";

            $all_server=$connSQL->query($requete);
            $cpt_server=count($all_server);

            for ($i=0; $i<$cpt_server; $i++) {
				$serverNames[]=$all_server[$i]->server_name;
            }
            
        }else{
            $serverNames=$this->guestAPI->getAllServers();
        }
		return $serverNames;
	}

	public function createArchiPlugin($old_archi,$newData){
		$tab_plugin=$old_archi;
        if(!isset($tab_plugin[$newData])){
			$tab_plugin[$newData]=array();
        }
		return $tab_plugin;
	}
}
?>
