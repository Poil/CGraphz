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

	$plugins=$c->getPlugins($id_prj);



	$jsonPluginTxt='[';
    $nb_p=0;
    $nb_pc=0;
    $nb_pi=0;
    $nb_t=0;
    $nb_tc=0;
    foreach($plugins as $p_name => $p){
        if($nb_p!=0) $jsonPluginTxt.=",";
        $nb_p++;
        $jsonPluginTxt.='{
                "text" : "<span niveau=\"plugin\" value=\"'.$p_name.'\">'.$p_name.'</span>",
                "children" : [';

        $nb_pc=0;
        $nb_pi=0;
        $nb_t=0;
        $nb_tc=0;
        foreach($p as $pc_name => $pc){
            if($pc_name!=="null"){
                if($nb_pc!=0) $jsonPluginTxt.=",";
                $nb_pc++;
                $jsonPluginTxt.='{
                            "text" : "<span niveau=\"plugin-categorie\" plugin=\"'.$p_name.'\" value=\"'.$pc_name.'\">'.$pc_name.'</span>",
                            "children" : [';
                $nb_pi=0;
                $nb_t=0;
                $nb_tc=0;
            }
            foreach($pc as $pi_name => $pi){
                if($pi_name!=="null"){
                    if($nb_pi!=0) $jsonPluginTxt.=",";
                    $nb_pi++;
                    $jsonPluginTxt.='{
                                "text" : "<span niveau=\"plugin-instance\" plugin=\"'.$p_name.'\" plugin-categorie=\"'.$pc_name.'\" value=\"'.$pi_name.'\">'.$pi_name.'</span>",
                                "children" : [';
                    $nb_t=0;
                    $nb_tc=0;
                }
                foreach($pi as $t_name => $t){
                    if($t_name!=="null"){
                        if($nb_t!=0) $jsonPluginTxt.=",";
                        $nb_t++;
                        $selected="false";
                        if($withGraph && $_GET['p']==$p_name && $_GET['pc']==$pc_name && $_GET['pi']==$pi_name && $_GET['t'] ==$t_name) $selected="true";

                        $jsonPluginTxt.='{
                                "state" : { "selected" : '.$selected.' },';

                        $jsonPluginTxt.='  "text" : "<span niveau=\"p-type\" plugin=\"'.$p_name.'\" plugin-categorie=\"'.$pc_name.'\" plugin-instance=\"'.$pi_name.'\" value=\"'.$t_name.'\" >'.$t_name.'</span>",
                                "children" : [';
                        $nb_tc=0;
                    }/*
					foreach($t as $tc_name => $ti_name){
                        if($tc_name!=="null"){
                            if($nb_tc!=0) echo ",";
                            $nb_tc++;

                            echo '{
                                    "text" : \'<span niveau="type-categorie" plugin="'.$p_name.'" plugin-categorie="'.$pc_name.'" plugin-instance="'.$pi_name.'" p-type="'.$t_name.'" value="'.$tc_name.'">'.$tc_name.'</span>\',';

                            echo '}';
                        }
                    }*/
                    if($t_name!=="null") $jsonPluginTxt.="]}";
                }
                if($pi_name!=="null") $jsonPluginTxt.="]}";
            }
            if($pc_name!=="null") $jsonPluginTxt.="]}";
        }
        $jsonPluginTxt.="]}";
    }
    $jsonPluginTxt.="]";
	 









	echo "{
			\"pluginJs\" : ".json_encode($plugins).",
			\"jsonPlugin\" : ".$jsonPluginTxt."
	}";	
}
?>
