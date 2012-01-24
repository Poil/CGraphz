<?php
if (isset($_POST['f_submit_plugin_filter'])) {
	
	$f_id_config_plugin_filter=intval($_POST['f_id_config_plugin_filter']);
	$f_plugin_filter_desc=mysql_escape_string($_POST['f_plugin_filter_desc']);
	$f_plugin_filter_p=mysql_escape_string($_POST['f_plugin_filter_p']);
	$f_plugin_filter_pi=mysql_escape_string($_POST['f_plugin_filter_pi']);
	$f_plugin_filter_t=mysql_escape_string($_POST['f_plugin_filter_t']);
	$f_plugin_filter_ti=mysql_escape_string($_POST['f_plugin_filter_ti']);
	$f_plugin_filter_plugin_order=intval($_POST['f_plugin_filter_plugin_order']);
		
	if ($_POST['f_id_config_plugin_filter']) { // UPDATE
		$lib='
			UPDATE `config_plugin_filter` SET
				`plugin_filter_desc`="'.$f_plugin_filter_desc.'",
				`plugin`="'.$f_plugin_filter_p.'",
				`plugin_instance`="'.$f_plugin_filter_pi.'",
				`type`="'.$f_plugin_filter_t.'",
				`type_instance`="'.$f_plugin_filter_ti.'",
				`plugin_order`="'.$f_plugin_filter_plugin_order.'"
			WHERE
				`id_config_plugin_filter`="'.$f_id_config_plugin_filter.'"';
	} else { // INSERT
		$lib='INSERT INTO `config_plugin_filter` (`id_config_plugin_filter`,`plugin_filter_desc`,`plugin`,`plugin_instance`,`type`,`type_instance`,`plugin_order`) 
			  VALUES ("'.$f_id_config_plugin_filter.'","'.$f_plugin_filter_desc.'","'.$f_plugin_filter_p.'","'.$f_plugin_filter_pi.'","'.$f_plugin_filter_t.'","'.$f_plugin_filter_ti.'","'.$f_plugin_filter_plugin_order.'")';
	}
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
