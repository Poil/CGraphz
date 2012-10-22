<?php
if (isset($_POST['f_submit_dynamic_dashboard'])) {
	$connSQL=new DB();
	
	$f_id_config_dynamic_dashboard=intval($_POST['f_id_config_dynamic_dashboard']);
	$f_title=mysql_escape_string(filter_input(INPUT_POST,'f_title',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_dynamic_dashboard_description=mysql_escape_string(filter_input(INPUT_POST,'f_dynamic_dashboard_description',FILTER_SANITIZE_SPECIAL_CHARS));
	
	if ($_POST['f_id_config_dynamic_dashboard']) { // UPDATE
		$lib='
			UPDATE `config_dynamic_dashboard` SET
				title="'.$f_title.'"
			WHERE
				id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';		

		$connSQL->query($lib);
		
	} else { // INSERT
		$lib='INSERT INTO `config_dynamic_dashboard` (`title`) 
		VALUES ("'.$f_title.'")';
		$connSQL->query($lib);
		
		$id_config_dynamic_dashboard=$connSQL->getLastInsertId();
		
		if ($id_config_dynamic_dashboard!==0) {
			$lib='SELECT ag.id_auth_group 
				FROM auth_group ag 
					LEFT JOIN auth_user_group aug  
						ON ag.id_auth_group=aug.id_auth_group 
				WHERE aug.id_auth_user="'.intval($_SESSION['S_ID_USER']).'"';			
			
			$cur_group=$connSQL->getResults($lib);
			$cpt_group=count($cur_group);
				
			for ($i=0; $i<$cpt_group; $i++) {
				$lib='INSERT INTO config_dynamic_dashboard_group 
						(id_config_dynamic_dashboard,id_auth_group,group_manager) 
					VALUES 
					("'.$id_config_dynamic_dashboard.'","'.$cur_group[$i]->id_auth_group.'","1")';
					
				$connSQL->query($lib);
			}
		}
	}
}
?>
