<?php
if (isset($_POST['f_submit_server_role'])) {
	
	$f_id_config_role=intval($_POST['f_id_config_role']);
	$f_id_config_server=intval($_POST['f_id_config_server']);

	$lib='INSERT INTO `config_role_server` 
			(`id_config_role`,`id_config_server`) 
		VALUES 
			("'.$f_id_config_role.'","'.$f_id_config_server.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
