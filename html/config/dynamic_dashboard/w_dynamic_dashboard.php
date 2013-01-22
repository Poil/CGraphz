<?php
if (isset($_POST['f_submit_dynamic_dashboard']) && $_POST['f_title']!='') {
	
	$f_id_config_dynamic_dashboard=intval($_POST['f_id_config_dynamic_dashboard']);
	$f_title=mysql_escape_string(filter_input(INPUT_POST,'f_title',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_dynamic_dashboard_description=mysql_escape_string(filter_input(INPUT_POST,'f_dynamic_dashboard_description',FILTER_SANITIZE_SPECIAL_CHARS));
		
	if ($_POST['f_id_config_dynamic_dashboard']) { // UPDATE
		$lib='
			UPDATE `config_dynamic_dashboard` SET
				title="'.$f_title.'"
			WHERE
				id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';
	} else { // INSERT
		$lib='INSERT INTO `config_dynamic_dashboard` (`title`) 
		VALUES ("'.$f_title.'")';
	}
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>