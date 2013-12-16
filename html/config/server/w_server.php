<?php
if (isset($_POST['f_submit_server'])) {
	$f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);
	$f_server_description=filter_input(INPUT_POST,'f_server_description',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_collectd_version=filter_input(INPUT_POST,'f_collectd_version',FILTER_SANITIZE_NUMBER_FLOAT);

	if ($_POST['f_id_config_server']) { // UPDATE
		$connSQL=new DB();
		$connSQL->bind('f_server_description',$f_server_description);
		$connSQL->bind('f_collectd_version',$f_collectd_version);
		$connSQL->bind('f_id_config_server',$f_id_config_server);
		
		$lib='
			UPDATE config_server SET
				server_description=:f_server_description,
				collectd_version=:f_collectd_version
			WHERE
				id_config_server=:f_id_config_server';
		$connSQL->query($lib);

	} else { // INSERT
		$connSQL=new DB();
		$f_server_name=filter_input(INPUT_POST,'f_server_name',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
		foreach ($f_server_name as $server_name) {
			$connSQL->bind('f_server_name',$f_server_name);
			$connSQL->bind('f_collectd_version',$f_collectd_version);
			$connSQL->bind('f_server_description',$f_server_description);

			$lib='INSERT INTO config_server (server_name, server_description, collectd_version) 
				VALUES (:f_server_name, :f_server_description, :f_collectd_version)';
			$connSQL->query($lib);
		}
	}
}
?>
