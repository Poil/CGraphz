<?php
if (isset($_POST['f_submit_project'])) {
	
	$f_id_config_project=intval($_POST['f_id_config_project']);
	$f_project=mysql_escape_string(filter_input(INPUT_POST,'f_project',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_project_description=mysql_escape_string(filter_input(INPUT_POST,'f_project_description',FILTER_SANITIZE_SPECIAL_CHARS));
		
	if ($_POST['f_id_config_project']) { // UPDATE
		$lib='
			UPDATE `config_project` SET
				`project`="'.$f_project.'",
				`project_description`="'.$f_project_description.'"
			WHERE
				`id_config_project`="'.$f_id_config_project.'"';
	} else { // INSERT
		$lib='INSERT INTO `config_project` (`id_config_project`,`project`,`project_description`) VALUES ("'.$f_id_config_project.'","'.$f_project.'","'.$f_project_description.'")';
	}
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
