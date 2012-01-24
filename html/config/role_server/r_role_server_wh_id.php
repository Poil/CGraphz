<?php
if (isset($_GET['f_id_config_server']) && isset($_GET['f_id_config_role'])) {
	$f_id_config_server=intval($_GET['f_id_config_server']);
	$f_id_config_role=intval($_GET['f_id_config_role']);
		
	$connSQL=new DB();
	$lib='SElECT 
			crs.id_config_role, 
			crs.id_config_server,
			cs.server_name, 
			cs.server_description
		FROM
			config_role_server crs
				LEFT JOIN config_server cs
					ON crs.id_config_server=cs.id_config_server
		WHERE crs.id_config_role="'.$f_id_config_role.'"
		AND crs.id_config_server="'.$f_id_config_server.'"';
	
	$cur_role_server=$connSQL->getRow($lib);
}
?>