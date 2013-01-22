<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
	$f_id_config_dynamic_dashboard=intval($_GET['f_id_config_dynamic_dashboard']);
		
	$connSQL=new DB();
	$lib='SELECT 
			cddg.id_config_dynamic_dashboard, 
			cddg.id_auth_group, 
			cddg.group_manager,
			cdd.title, 
			ag.`group`,
			ag.group_description
		FROM
			config_dynamic_dashboard_group cddg
				LEFT JOIN config_dynamic_dashboard cdd
					ON cddg.id_config_dynamic_dashboard=cdd.id_config_dynamic_dashboard
				LEFT JOIN auth_group ag
					ON cddg.id_auth_group=ag.id_auth_group
		WHERE cddg.id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';

	$all_dynamic_dashboard_group=$connSQL->getResults($lib);
	$cpt_dynamic_dashboard_group=count($all_dynamic_dashboard_group);
	
	
	$lib='SELECT 
			* 
		FROM 
			auth_group
		WHERE 
			id_auth_group NOT IN (
				SELECT id_auth_group 
				FROM auth_user_group
				WHERE id_auth_user="'.$f_id_auth_user.'"
			)
		ORDER BY 
			`group`';
	
	$connSQL=new DB();
	$all_group=$connSQL->getResults($lib);
	$cpt_group=count($all_group);
}
?>