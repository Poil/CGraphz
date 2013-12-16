<?php
if (isset($_POST['f_submit_server_role'])) {
	$f_id_config_role=filter_input(INPUT_POST,'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);

	$lib='INSERT INTO config_role_server
			(id_config_role, id_config_server) 
		VALUES 
			(:f_id_config_role, :f_id_config_server)';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_role',$f_id_config_role);
	$connSQL->bind('f_id_config_server',$f_id_config_server);
	$connSQL->query($lib);
}
?>
