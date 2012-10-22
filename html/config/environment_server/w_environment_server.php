<?php
if (isset($_POST['f_submit_environment_server'])) {
	
	$f_id_config_environment=intval($_POST['f_id_config_environment']);
	$f_id_config_server=intval($_POST['f_id_config_server']);
	$f_filter_server_in_environment=mysql_escape_string(filter_input(INPUT_POST,'f_filter_server_in_environment',FILTER_SANITIZE_SPECIAL_CHARS));

	if ($f_id_config_server) {
		foreach ($f_id_config_server as $value) {
			$id_config_server=intval($value);
			
			$lib='INSERT INTO `config_environment_server`
					(`id_config_environment`,`id_config_server`) 
				VALUES 
					("'.$f_id_config_environment.'","'.$id_config_server.'")';
			
			$connSQL=new DB();
			$connSQL->query($lib);
		}
	}
} else {
	$f_filter_server_in_environment='true';
}
?>
