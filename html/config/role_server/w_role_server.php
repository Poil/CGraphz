<?php
if (isset($_POST['f_submit_role_server'])) {
	$f_id_config_role=filter_input(INPUT_POST,'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
	$f_filter_server_in_role=$_POST['f_filter_server_in_role'];

	foreach ($f_id_config_server as $id_config_server) {
		
		$lib='INSERT INTO config_role_server
				(id_config_role,id_config_server) 
			VALUES 
				(:f_id_config_role, :id_config_server)';
		
		$connSQL=new DB();
		$connSQL->bind('f_id_config_role',$f_id_config_role);
		$connSQL->bind('id_config_server',$id_config_server);
		$connSQL->query($lib);
	}
} else {
	$f_filter_server_in_role='true';
}
?>
