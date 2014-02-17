<?php
if (isset($_POST['f_submit_dynamic_dashboard'])) {
	$connSQL=new DB();
	
	$f_id_config_dynamic_dashboard=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
	$f_title=filter_input(INPUT_POST,'f_title',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_dynamic_dashboard_description=filter_input(INPUT_POST,'f_dynamic_dashboard_description',FILTER_SANITIZE_SPECIAL_CHARS);
	$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);
	
	if ($_POST['f_id_config_dynamic_dashboard']) { // UPDATE
		$lib='
			UPDATE config_dynamic_dashboard SET
				title=:f_title
			WHERE
				id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';		

		$connSQL->query($lib);
		
	} else { // INSERT
		$lib='INSERT INTO config_dynamic_dashboard (title) 
		VALUES (:f_title)';
		$connSQL->bind('f_title',$f_title);
		$connSQL->query($lib);
		
		$id_config_dynamic_dashboard=$connSQL->lastInsertId();
		
		if ($id_config_dynamic_dashboard!==0) {
			$lib='SELECT ag.id_auth_group 
				FROM auth_group ag 
					LEFT JOIN auth_user_group aug  
						ON ag.id_auth_group=aug.id_auth_group 
				WHERE aug.id_auth_user=:s_id_user';

			$connSQL->bind('s_id_user',$s_id_user);
			$cur_group=$connSQL->query($lib);
			$cpt_group=count($cur_group);
				
			for ($i=0; $i<$cpt_group; $i++) {
				$id_auth_group=$cur_group[$i]->id_auth_group;

				$lib='INSERT INTO config_dynamic_dashboard_group 
						(id_config_dynamic_dashboard, id_auth_group, group_manager) 
					VALUES 
					(:id_config_dynamic_dashboard, :id_auth_group ,1)';
				$connSQL->bind('id_config_dynamic_dashboard',$id_config_dynamic_dashboard);
				$connSQL->bind('id_auth_group',$id_auth_group);
				$connSQL->query($lib);
			}
		}
	}
}
?>
