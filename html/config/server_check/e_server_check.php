<?php
if (isset($_POST['f_del_server_check'])) {
	foreach ($_POST['f_server_name_to_del'] as $f_server_name) {
		
		$server_name=mysql_escape_string($f_server_name);
		
		$connSQL=new DB();
	
		$lib='SELECT id_config_server FROM config_server WHERE server_name="'.$server_name.'"';
		$cur_todelete_server=$connSQL->getRow($lib);
		
		$lib='DELETE FROM `config_role_server` WHERE id_config_server="'.$cur_todelete_server->id_config_server.'"';
		$connSQL->query($lib);
		
		$lib='DELETE FROM `config_environment_server` WHERE id_config_server="'.$cur_todelete_server->id_config_server.'"';
		$connSQL->query($lib);
		
		$lib='DELETE FROM `config_server_project` WHERE id_config_server="'.$cur_todelete_server->id_config_server.'"';
		$connSQL->query($lib);
		
		$lib='DELETE FROM `config_server` WHERE id_config_server="'.$cur_todelete_server->id_config_server.'"';
		$connSQL->query($lib);
	}
}
?>
