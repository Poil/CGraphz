<?php
if (isset($_POST['f_submit_group_plugin_filter'])) {
	
	$f_id_config_plugin_filter=intval($_POST['f_id_config_plugin_filter']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	

	$lib='INSERT INTO `config_plugin_filter_group` (`id_config_plugin_filter`,`id_auth_group`)
			VALUES ("'.$f_id_config_plugin_filter.'","'.$f_id_auth_group.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>