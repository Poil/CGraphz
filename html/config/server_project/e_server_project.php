<?php
if (isset($_POST['f_delete_server_project'])) {
	$f_id_config_project=intval($_POST['f_id_config_project']);
	$f_id_config_server=intval($_POST['f_id_config_server']);
	
	$lib='DELETE FROM `config_server_project` WHERE id_config_project="'.$f_id_config_project.'" AND id_config_server="'.$f_id_config_server.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>
