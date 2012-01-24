<?php
if (isset($_POST['f_delete_group_plugin_filter'])) {
	$f_id_config_plugin_filter=intval($_POST['f_id_config_plugin_filter']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	
	$lib='DELETE FROM `config_plugin_filter_group` WHERE id_config_plugin_filter="'.$f_id_config_plugin_filter.'" AND id_auth_group="'.$f_id_auth_group.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>