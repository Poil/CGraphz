<?php
if (isset($_GET['f_id_auth_group'])) {
	$f_id_auth_group=filter_input(INPUT_GET,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
		
	$connSQL=new DB();
	$lib='SELECT 
			ppg.id_config_project, 
			ppg.id_auth_group,  
			cp.project, 
			cp.project_description,
			ag.group,
			ag.group_description
		FROM
			perm_project_group ppg
				LEFT JOIN config_project cp
					ON ppg.id_config_project=cp.id_config_project
				LEFT JOIN auth_group ag
					ON ppg.id_auth_group=ag.id_auth_group
		WHERE ag.id_auth_group=:f_id_auth_group';

	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$all_group_project=$connSQL->query($lib);
	$cpt_group_project=count($all_group_project);
	

	$lib='SELECT 
			* 
		FROM 
			config_project cp
		WHERE 
			id_config_project NOT IN (
				SELECT id_config_project 
				FROM perm_project_group
				WHERE id_auth_group=:f_id_auth_group
			)
		ORDER BY 
			cp.project';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$all_project=$connSQL->query($lib);
	$cpt_project=count($all_project);
}
?>
