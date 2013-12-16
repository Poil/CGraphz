<?php
if (isset($_POST['f_delete_server_environment'])) {
	$f_id_config_environment=filter_input(INPUT_POST,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);
	
	$lib='DELETE FROM config_environment_server WHERE id_config_environment=:f_id_config_environment AND id_config_server=:f_id_config_server';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_environment',$f_id_config_environment);
	$connSQL->bind('f_id_config_server',$f_id_config_server);
	$connSQL->query($lib);
}

?>
