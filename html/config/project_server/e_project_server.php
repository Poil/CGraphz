<?php
if (isset($_POST['f_delete_project_server'])) {
	$f_id_config_project=filter_input(INPUT_POST,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);
	
	$lib='DELETE FROM config_server_project WHERE id_config_project=:f_id_config_project AND id_config_server=:f_id_config_server';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_project',$f_id_config_project);
	$connSQL->bind('f_id_config_server',$f_id_config_server);
	$connSQL->query($lib);
}

?>
