<?php
if (isset($_POST['f_submit_dynamic_dashboard']) && $_POST['f_title']!='') {
	$f_id_config_dynamic_dashboard=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
	$f_title=filter_input(INPUT_POST,'f_title',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_dynamic_dashboard_description=filter_input(INPUT_POST,'f_dynamic_dashboard_description',FILTER_SANITIZE_SPECIAL_CHARS);
		
	$connSQL=new DB();
	if ($_POST['f_id_config_dynamic_dashboard']) { // UPDATE
		$lib='
			UPDATE config_dynamic_dashboard SET
				title=:f_title
			WHERE
				id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
		$connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
	} else { // INSERT
		$lib='INSERT INTO config_dynamic_dashboard (title) 
		VALUES (:f_title)';
	}
	
	$connSQL->bind('f_title',$f_title);
	$connSQL->query($lib);
}
?>
