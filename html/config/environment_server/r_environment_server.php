<?php
if (isset($_GET['f_id_config_environment'])) {
	$f_id_config_environment=filter_input(INPUT_GET,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
		
	$connSQL=new DB();
	$lib='SELECT 
			crs.id_config_environment, 
			crs.id_config_server, 
			cr.environment, 
			cs.server_name,
			cs.server_description
		FROM
			config_environment_server crs
				LEFT JOIN config_server cs
					ON crs.id_config_server=cs.id_config_server
				LEFT JOIN config_environment cr
					ON crs.id_config_environment=cr.id_config_environment
		WHERE crs.id_config_environment=:f_id_config_environment';

	$connSQL->bind('f_id_config_environment',$f_id_config_environment);
	$all_environment_server=$connSQL->query($lib);
	$cpt_environment_server=count($all_environment_server);
	
	$connSQL=new DB();
	// To check !
	if ($f_filter_server_in_environment!='true') {
		$lib='SELECT 
			* 
		FROM 
			config_server
		WHERE 
			id_config_server NOT IN (
				SELECT id_config_server 
				FROM config_environment_server
				WHERE id_config_environment=:f_id_config_environment
			)
		ORDER BY 
			server_name';
		$connSQL->bind('f_id_config_environment',$f_id_config_environment);
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
			server_name';
	}
	$all_server=$connSQL->query($lib);
	$cpt_server=count($all_server);
}
?>
