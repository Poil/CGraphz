<?php
if (isset($_POST['f_submit_server'])) {
	
	$f_id_config_server=intval($_POST['f_id_config_server']);
	$f_server_description=mysql_escape_string(filter_input(INPUT_POST,'f_server_description',FILTER_SANITIZE_SPECIAL_CHARS));
	$connSQL=new DB();
	
	if ($_POST['f_id_config_server']) { // UPDATE
		$f_server_name=mysql_escape_string($_POST['f_server_name']);
		$lib='
			UPDATE `config_server` SET
				`server_description`="'.$f_server_description.'"
			WHERE
				`id_config_server`="'.$f_id_config_server.'"';
		$connSQL->query($lib);
	} else { // INSERT
		$f_server_name=$_POST['f_server_name'];
		foreach ($f_server_name as $value) {
			$server_name=mysql_escape_string($value);
			$lib='INSERT INTO `config_server` (`id_config_server`,`server_name`,`server_description`) VALUES ("'.$f_id_config_server.'","'.$server_name.'","'.$f_server_description.'")';
			$connSQL->query($lib);
		}
	}
}
?>
