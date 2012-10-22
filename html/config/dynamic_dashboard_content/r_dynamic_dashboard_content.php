<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
	$f_id_config_dynamic_dashboard=intval($_GET['f_id_config_dynamic_dashboard']);

	$all_dynamic_dashboard_content=$connSQL->getResults('SELECT * FROM config_dynamic_dashboard_content 
		WHERE id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'" ORDER BY dash_ordering');
		
	$cpt_dynamic_dashboard_content=count($all_dynamic_dashboard_content);
	

	$connSQL=new DB();
	$all_plugin_filter=$connSQL->getResults('SELECT * FROM config_plugin_filter ORDER BY plugin_order, plugin_filter_desc');
	$cpt_plugin_filter=count($all_plugin_filter);

}
?>