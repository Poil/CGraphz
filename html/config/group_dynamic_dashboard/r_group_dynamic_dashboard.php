<?php
if ($_GET['f_id_auth_group']) {
	$f_id_auth_group=filter_input(INPUT_GET,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
		
	$connSQL=new DB();
	$lib='SELECT 
			cdd.id_config_dynamic_dashboard, 
			cddg.id_auth_group, 
			cdd.title
		FROM
			config_dynamic_dashboard_group cddg
				LEFT JOIN config_dynamic_dashboard cdd
					ON cddg.id_config_dynamic_dashboard=cdd.id_config_dynamic_dashboard
				LEFT JOIN auth_group ag
					ON cddg.id_auth_group=ag.id_auth_group
		WHERE cddg.id_auth_group=:f_id_auth_group
		ORDER BY title';

	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$all_group_dynamic_dashboard=$connSQL->query($lib);
	$cpt_group_dynamic_dashboard=count($all_group_dynamic_dashboard);

	$lib='SELECT 
			*
		FROM 
			config_dynamic_dashboard
		WHERE 
			id_config_dynamic_dashboard NOT IN (
				SELECT id_config_dynamic_dashboard
				FROM config_dynamic_dashboard_group
				WHERE id_auth_group=:f_id_auth_group
			)
		ORDER BY 
			title';
			
	$connSQL=new DB();
	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$all_dynamic_dashboard=$connSQL->query($lib);
	$cpt_dynamic_dashboard=count($all_dynamic_dashboard);

}
?>
