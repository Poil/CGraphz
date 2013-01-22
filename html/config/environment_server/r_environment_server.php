<?php
if (isset($_GET['f_id_config_environment'])) {
	$f_id_config_project=intval($_GET['f_id_config_environment']);
		
	$connSQL=new DB();
	$lib='SELECT 
			crs.id_config_environment, 
			crs.id_config_server, 
			cr.`environment`, 
			cs.`server_name`,
			cs.server_description
		FROM
			config_environment_server crs
				LEFT JOIN config_server cs
					ON crs.id_config_server=cs.id_config_server
				LEFT JOIN config_environment cr
					ON crs.id_config_environment=cr.id_config_environment
		WHERE crs.id_config_environment="'.$f_id_config_environment.'"';

	$all_environment_server=$connSQL->getResults($lib);
	$cpt_environment_server=count($all_environment_server);
	
	if ($f_filter_server_in_environment!='true') {
		$lib='SELECT 
			* 
		FROM 
			config_server
		WHERE 
			id_config_server NOT IN (
				SELECT id_config_server 
				FROM config_environment_server
				WHERE id_config_environment="'.$f_id_config_environment.'"
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
				FROM config_environment_server
			)
		ORDER BY 
			`server_name`';
	}
	$connSQL=new DB();
	$all_server=$connSQL->getResults($lib);
	$cpt_server=count($all_server);
}
?>
