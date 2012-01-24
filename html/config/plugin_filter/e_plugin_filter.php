<?php
if (isset($_POST['f_del_plugin_filter'])) {
	$f_id_config_plugin_filter=intval($_POST['f_id_config_plugin_filter']);

	$lib='DELETE FROM `config_plugin_filter` WHERE id_config_plugin_filter="'.$f_id_config_plugin_filter.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
