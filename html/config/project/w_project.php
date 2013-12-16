<?php
if (isset($_POST['f_submit_project'])) {
	
	$f_id_config_project=filter_input(INPUT_POST,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
	$f_project=filter_input(INPUT_POST,'f_project',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_project_description=filter_input(INPUT_POST,'f_project_description',FILTER_SANITIZE_SPECIAL_CHARS);
		
	if ($_POST['f_id_config_project']) { // UPDATE
		$lib='
			UPDATE config_project SET
				project=:f_project,
				project_description=:f_project_description
			WHERE
				id_config_project=:f_id_config_project';
	} else { // INSERT
		$lib='INSERT INTO config_project (id_config_project, project, project_description) 
		VALUES (:f_id_config_project, :f_project, :f_project_description)';
	}
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_project',$f_id_config_project);
	$connSQL->bind('f_project_description',$f_project_description);
	$connSQL->bind('f_project',$f_project);
	$connSQL->query($lib);
}
?>
