<?php
if (isset($_POST['f_submit_group_plugin_filter'])) {
	
	$f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
	
	$f_id_config_plugin_filter=filter_input(INPUT_POST,'f_id_config_plugin_filter',FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);

	foreach ($f_id_config_plugin_filter as $id_config_plugin_filter) {
		$lib='INSERT INTO config_plugin_filter_group (id_config_plugin_filter,id_auth_group)
				VALUES (:id_config_plugin_filter,:f_id_auth_group)';
		
		$connSQL=new DB();
		$connSQL->bind('id_config_plugin_filter',$id_config_plugin_filter);
		$connSQL->bind('f_id_auth_group',$f_id_auth_group);
		$connSQL->query($lib);
	}
}
?>
