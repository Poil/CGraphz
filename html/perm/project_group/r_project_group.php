<?php
if (isset($_GET['f_id_config_project'])) {
	$f_id_config_project=intval($_GET['f_id_config_project']);
		
	$connSQL=new DB();
	$lib='SELECT 
			ppg.id_config_project, 
			ppg.id_auth_group, 
			cp.`project`, 
			ag.`group`,
			ag.group_description
		FROM
			perm_project_group ppg
				LEFT JOIN config_project cp
					ON ppg.id_config_project=cp.id_config_project
				LEFT JOIN auth_group ag
					ON ppg.id_auth_group=ag.id_auth_group
		WHERE ppg.id_config_project="'.$f_id_config_project.'"';

	$all_project_group=$connSQL->getResults($lib);
	$cpt_project_group=count($all_project_group);
	
	
	$lib='SELECT 
			* 
		FROM 
			auth_group
		WHERE 
			id_auth_group NOT IN (
				SELECT id_auth_group 
				FROM perm_project_group
				WHERE id_config_project="'.$f_id_config_project.'"
			)
		ORDER BY 
			`group`';
	
	$connSQL=new DB();
	$all_group=$connSQL->getResults($lib);
	$cpt_group=count($all_group);
}
?>
