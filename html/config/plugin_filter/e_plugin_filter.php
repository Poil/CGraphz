<?php
if (isset($_POST['f_del_plugin_filter'])) {
	$f_id_config_plugin_filter=filter_input(INPUT_POST,'f_id_config_plugin_filter',FILTER_SANITIZE_NUMBER_INT);

	$lib='DELETE FROM config_plugin_filter WHERE id_config_plugin_filter=:f_id_config_plugin_filter';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_plugin_filter',$f_id_config_plugin_filter);
	$connSQL->query($lib);
}
?>
