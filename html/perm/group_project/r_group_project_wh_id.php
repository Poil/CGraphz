<?php
if (isset($_GET['f_id_config_project']) && isset($_GET['f_id_auth_group'])) {
	$f_id_config_project=intval($_GET['f_id_config_project']);
	$f_id_auth_group=intval($_GET['f_id_auth_group']);
		
	$connSQL=new DB();
	/* A FAIRE A PARTIR D'ICI DEMAIN GROS BOULET */
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
		WHERE ppg.id_config_project="'.$f_id_config_project.'"
		AND ppg.id_auth_group="'.$f_id_auth_group.'"';
	
	$cur_group_project=$connSQL->getRow($lib);
}
?>
