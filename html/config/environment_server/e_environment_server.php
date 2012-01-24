<?php
if (isset($_POST['f_delete_environment_server'])) {
	$f_id_config_environment=intval($_POST['f_id_config_environment']);
	$f_id_config_server=intval($_POST['f_id_config_server']);
	
	$lib='DELETE FROM `config_environment_server` WHERE id_config_environment="'.$f_id_config_environment.'" AND id_config_server="'.$f_id_config_server.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>