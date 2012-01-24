<?php
if (isset($_GET['f_id_config_role'])) {
	$f_id_config_project=intval($_GET['f_id_config_role']);
		
	$connSQL=new DB();
	$lib='SELECT 
			crs.id_config_role, 
			crs.id_config_server, 
			cr.`role`, 
			cs.`server_name`,
			cs.server_description
		FROM
			config_role_server crs
				LEFT JOIN config_server cs
					ON crs.id_config_server=cs.id_config_server
				LEFT JOIN config_role cr
					ON crs.id_config_role=cr.id_config_role
		WHERE crs.id_config_role="'.$f_id_config_role.'"';

	$all_role_server=$connSQL->getResults($lib);
	$cpt_role_server=count($all_role_server);
	
	if ($f_filter_server_in_role!='true') {
		$lib='SELECT 
			* 
		FROM 
			config_server
		WHERE 
			id_config_server NOT IN (
				SELECT id_config_server 
				FROM config_role_server
				WHERE id_config_role="'.$f_id_config_role.'"
			)
		ORDER BY 
			`server_name`';
	} else {
		$lib='SELECT 
			* 
		FROM 
			config_server
		WHERE 
			id_config_server NOT IN (
				SELECT id_config_server 
				FROM config_role_server
			)
		ORDER BY 
			`server_name`';
	}
	$connSQL=new DB();
	$all_server=$connSQL->getResults($lib);
	$cpt_server=count($all_server);
}
?>
