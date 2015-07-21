<?php
require('../../../../../config/config.php');

require(DIR_FSROOT.'/modules/claranet/component/compare/Compare.class.php');

if(isset($_GET['id_prj'])){
	$id_prj=$_GET['id_prj'];
    $c=new Compare($CONFIG);

	
	$withGraph=false;
    if(isset($_GET['p']) && isset($_GET['pc']) && isset($_GET['pi']) && isset($_GET['t']) && isset($_GET['tc'])){
        $withGraph=true;
        if(empty($_GET['p'])) $_GET['p']="null";
        if(empty($_GET['pc'])) $_GET['pc']="null";
        if(empty($_GET['pi'])) $_GET['pi']="null";
        if(empty($_GET['t'])) $_GET['t']="null";
    }

	$plugins_datadir=$c->getPlugins($id_prj);



	

	$arrayPlugin=array();
	foreach($plugins_datadir as $datadir => $plugins){
	    foreach($plugins as $p_name => $p){
			
			$arrayPC=array();
	        foreach($p as $pc_name => $pc){
				$arrayPI=array();
	            foreach($pc as $pi_name => $pi){
					$arrayT=array();
	                foreach($pi as $t_name => $t){
						$tempT=array();
						if($t_name!=="null"){
							$selected=false;
	                        if($withGraph && $_GET['p']==$p_name && $_GET['pc']==$pc_name && $_GET['pi']==$pi_name && $_GET['t'] ==$t_name) $selected=true;
	
							$tempT['state']=array("selected" => $selected);
							$tempT['text']= '<span niveau="p-type" datadir="'.$datadir.'" plugin="'.$p_name.'" plugin-categorie="'.$pc_name.'" plugin-instance="'.$pi_name.'" value="'.$t_name.'" >'.$t_name.'</span>';
	
							$arrayT[]=$tempT;
						}
	
	                }
					$tempPI=array();
	                if($pi_name!=="null"){
	                    $tempPI['text']= '<span niveau="plugin-instance" datadir="'.$datadir.'" plugin="'.$p_name.'" plugin-categorie="'.$pc_name.'" value="'.$pi_name.'">'.$pi_name.'</span>';
						if(!empty($arrayT)){
							$tempPI['children']=$arrayT;
						}
	
	                    $arrayPI[]=$tempPI;
	                }else{
						$arrayPI=array_merge($arrayPI,$arrayT);
					}
	            }
	
				$tempPC=array();
	            if($pc_name!=="null"){
	                $tempPC['text']= '<span niveau="plugin-categorie" datadir="'.$datadir.'" plugin="'.$p_name.'" value="'.$pc_name.'">'.$pc_name.'</span>';
	                if(!empty($arrayPI)){
	                    $tempPC['children']=$arrayPI;
	                }
	
	                $arrayPC[]=$tempPC;
	            }else{
	                $arrayPC=array_merge($arrayPC,$arrayPI);
	            }
	
	        }
	
			$tempPlugin=array();
	        if($p_name!=="null"){
	            $tempPlugin['text']= '<span niveau="plugin" datadir="'.$datadir.'" value="'.$p_name.'">'.$p_name.'</span>';
	            if(!empty($arrayPC)){
	                $tempPlugin['children']=$arrayPC;
	            }
	
	            $arrayPlugin[]=$tempPlugin;
	        }else{
	            $arrayPlugin=array_merge($arrayPlugin,$arrayPC);
	        }
	
	    }
	}
	 





	echo "{
			\"pluginJs\" : ".json_encode($plugins_datadir).",
			\"jsonPlugin\" : ".json_encode($arrayPlugin)."
	}";	
}
?>
