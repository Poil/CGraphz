<?php
if (isset($_GET['f_id_config_environment']) && isset($_GET['f_id_config_server'])) {
	$f_id_config_environment=intval($_GET['f_id_config_environment']);
	$f_id_config_server=intval($_GET['f_id_config_server']);
		
	$connSQL=new DB();
	/* A FAIRE A PARTIR D'ICI DEMAIN GROS BOULET */
	$lib='SELECT 
			ces.id_config_environment, 
			ces.id_config_server, 
			ce.`environment`, 
			ce.environment_description
		FROM
			config_environment_server ces
				LEFT JOIN config_environment ce
					ON ces.id_config_environment=ce.id_config_environment
				LEFT JOIN config_server cs
					ON ces.id_config_server=cs.id_config_server
		WHERE ces.id_config_environment="'.$f_id_config_environment.'"
		AND ces.id_config_server="'.$f_id_config_server.'"';
	
	$cur_server_environment=$connSQL->getRow($lib);
}
?>
