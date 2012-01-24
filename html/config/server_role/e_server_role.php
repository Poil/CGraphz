<?php
if (isset($_POST['f_delete_server_role'])) {
	$f_id_config_role=intval($_POST['f_id_config_role']);
	$f_id_config_server=intval($_POST['f_id_config_server']);
	
	$lib='DELETE FROM `config_role_server` WHERE id_config_role="'.$f_id_config_role.'" AND id_config_server="'.$f_id_config_server.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>
