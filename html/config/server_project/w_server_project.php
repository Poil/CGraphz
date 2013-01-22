<?php
if (isset($_POST['f_submit_server_project'])) {
	
	$f_id_config_project=intval($_POST['f_id_config_project']);
	$f_id_config_server=intval($_POST['f_id_config_server']);

	$lib='INSERT INTO `config_server_project` 
			(`id_config_project`,`id_config_server`) 
		VALUES 
			("'.$f_id_config_project.'","'.$f_id_config_server.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
