<?php
if (isset($_GET['f_id_config_plugin_filter']) && isset($_GET['f_id_auth_group'])) {
	$f_id_config_plugin_filter=filter_input(INPUT_GET,'f_id_config_plugin_filter',FILTER_SANITIZE_NUMBER_INT);
	$f_id_auth_group=filter_input(INPUT_GET,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
		
	$connSQL=new DB();
	$lib='SElECT 
			cpfg.id_config_plugin_filter, 
			cpfg.id_auth_group, 
			cpf.plugin_filter_desc
		FROM
			config_plugin_filter_group cpfg
				LEFT JOIN auth_group ag
					ON cpfg.id_auth_group=ag.id_auth_group
				LEFT JOIN config_plugin_filter cpf
					ON cpf.id_config_plugin_filter=cpfg.id_config_plugin_filter
		WHERE cpfg.id_config_plugin_filter=:f_id_config_plugin_filter
		AND cpfg.id_auth_group=:f_id_auth_group';

	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$connSQL->bind('f_id_config_plugin_filter',$f_id_config_plugin_filter);
	$cur_group_plugin_filter=$connSQL->row($lib);
}
?>
