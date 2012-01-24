<?php
if (isset($_GET['f_id_config_plugin_filter'])) {
	$f_id_config_plugin_filter=intval($_GET['f_id_config_plugin_filter']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_plugin_filter WHERE id_config_plugin_filter="'.$f_id_config_plugin_filter.'"';
	$cur_plugin_filter=$connSQL->getRow($lib);
}
?>
