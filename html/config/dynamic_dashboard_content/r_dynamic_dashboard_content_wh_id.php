<?php
if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
	$f_id_config_dynamic_dashboard_content=filter_input(INPUT_GET,'f_id_config_dynamic_dashboard_content',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_dynamic_dashboard_content',$f_id_config_dynamic_dashboard_content);
	$lib='SELECT * FROM config_dynamic_dashboard_content WHERE id_config_dynamic_dashboard_content=:f_id_config_dynamic_dashboard_content';
	$cur_dynamic_dashboard_content=$connSQL->row($lib);
}
?>
