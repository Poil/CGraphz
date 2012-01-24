<?php
if (isset($_POST['f_submit_role_server'])) {
	
	$f_id_config_role=intval($_POST['f_id_config_role']);
	$f_id_config_server=$_POST['f_id_config_server'];
	$f_filter_server_in_role=mysql_escape_string($_POST['f_filter_server_in_role']);

	foreach ($f_id_config_server as $value) {
		$id_config_server=intval($value);
		
		$lib='INSERT INTO `config_role_server`
				(`id_config_role`,`id_config_server`) 
			VALUES 
				("'.$f_id_config_role.'","'.$id_config_server.'")';
		
		$connSQL=new DB();
		$connSQL->query($lib);
	}
} else {
	$f_filter_server_in_role='true';
}
?>
