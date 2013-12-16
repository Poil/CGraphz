<?php
if (isset($_GET['f_id_config_plugin_filter'])) {
	$f_id_config_plugin_filter=filter_input(INPUT_GET,'f_id_config_plugin_filter',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_plugin_filter WHERE id_config_plugin_filter=:f_id_config_plugin_filter';
	$connSQL->bind('f_id_config_plugin_filter',$f_id_config_plugin_filter);
	$cur_plugin_filter=$connSQL->row($lib);
}
?>
