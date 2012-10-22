<?php
if (isset($_POST['f_submit_project_server'])) {
	
	$f_id_config_project=intval($_POST['f_id_config_project']);
	$f_id_config_server=intval($_POST['f_id_config_server']);
	$f_filter_server_in_project=mysql_escape_string(filter_input(INPUT_POST,'f_filter_server_in_project',FILTER_SANITIZE_SPECIAL_CHARS));
	
	foreach ($f_id_config_server as $value) {
		$id_config_server=intval($value);
	
		$lib='INSERT INTO `config_server_project` 
				(`id_config_project`,`id_config_server`) 
			VALUES 
				("'.$f_id_config_project.'","'.$id_config_server.'")';
		
		$connSQL=new DB();
		$connSQL->query($lib);
	}
} else {
        $f_filter_server_in_project='true';
}
?>
