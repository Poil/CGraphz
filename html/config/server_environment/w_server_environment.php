<?php
if (isset($_POST['f_submit_server_environment'])) {
	
	$f_id_config_environment=intval($_POST['f_id_config_environment']);
	$f_id_config_server=intval($_POST['f_id_config_server']);

	$lib='INSERT INTO `config_environment_server` 
			(`id_config_environment`,`id_config_server`) 
		VALUES 
			("'.$f_id_config_environment.'","'.$f_id_config_server.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
