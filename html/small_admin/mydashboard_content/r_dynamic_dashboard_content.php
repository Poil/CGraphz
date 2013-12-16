<?php
if (isset($_GET['f_id_config_dynamic_dashboard']) && $cur_dynamic_dashboard) {
	$f_id_config_dynamic_dashboard_content=filter_input(INPUT_GET,'f_id_config_dynamic_dashboard_content',FILTER_SANITIZE_NUMBER_INT);

	$connSQL=new DB();
	$all_dynamic_dashboard_content=$connSQL->query('SELECT * FROM config_dynamic_dashboard_content 
		WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard ORDER BY dash_ordering');
	$cpt_dynamic_dashboard_content=count($all_dynamic_dashboard_content);

	$connSQL=new DB();
	$connSQL->bind('f_id_config_dynamic_dashboard_content',$f_id_config_dynamic_dashboard_content);
	$all_plugin_filter=$connSQL->query('SELECT * FROM config_plugin_filter ORDER BY plugin_order, plugin_filter_desc');
	$cpt_plugin_filter=count($all_plugin_filter);

}
?>
