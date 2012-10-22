<?php
if (isset($_POST['f_submit_environment'])) {
	
	$f_id_config_environment=intval($_POST['f_id_config_environment']);
	$f_environment=mysql_escape_string(filter_input(INPUT_POST,'f_environment',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_environment_description=mysql_escape_string(filter_input(INPUT_POST,'f_environment_description',FILTER_SANITIZE_SPECIAL_CHARS));
		
	if ($_POST['f_id_config_environment']) { // UPDATE
		$lib='
			UPDATE `config_environment` SET
				`environment`="'.$f_environment.'",
				`environment_description`="'.$f_environment_description.'"
			WHERE
				`id_config_environment`="'.$f_id_config_environment.'"';
	} else { // INSERT
		$lib='INSERT INTO `config_environment` (`id_config_environment`,`environment`,`environment_description`) VALUES ("'.$f_id_config_environment.'","'.$f_environment.'","'.$f_environment_description.'")';
	}
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
