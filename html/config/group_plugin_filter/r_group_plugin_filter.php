<?php
if ($_GET['f_id_auth_group']) {
	$f_id_auth_group=filter_input(INPUT_GET,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

	$connSQL=new DB();
	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$lib='SELECT 
			cpfg.id_config_plugin_filter, 
			cpfg.id_auth_group, 
			cpf.plugin_filter_desc,
			cpf.plugin_order
		FROM
			config_plugin_filter_group cpfg
				LEFT JOIN config_plugin_filter cpf
					ON cpfg.id_config_plugin_filter=cpf.id_config_plugin_filter
				LEFT JOIN auth_group ag
					ON cpfg.id_auth_group=ag.id_auth_group
		WHERE cpfg.id_auth_group=:f_id_auth_group
		ORDER BY plugin_order';

	$all_group_plugin_filter=$connSQL->query($lib);
	$cpt_group_plugin_filter=count($all_group_plugin_filter);
	
	$connSQL=new DB();
	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$lib='SELECT 
			* 
		FROM 
			config_plugin_filter
		WHERE 
			id_config_plugin_filter NOT IN (
				SELECT id_config_plugin_filter 
				FROM config_plugin_filter_group
				WHERE id_auth_group=:f_id_auth_group
			)
		ORDER BY 
			plugin_filter_desc';

	$all_plugin_filter=$connSQL->query($lib);
	$cpt_plugin_filter=count($all_plugin_filter);

}
?>
