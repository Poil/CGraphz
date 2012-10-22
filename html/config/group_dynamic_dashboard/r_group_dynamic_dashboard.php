<?php
if ($_GET['f_id_auth_group']) {
	$f_id_auth_group=intval($_GET['f_id_auth_group']);
		
	$connSQL=new DB();
	$lib='SELECT 
			cpfg.id_config_plugin_filter, 
			cpfg.id_auth_group, 
			cpf.`plugin_filter_desc`,
			cpf.`plugin_order`
		FROM
			config_plugin_filter_group cpfg
				LEFT JOIN config_plugin_filter cpf
					ON cpfg.id_config_plugin_filter=cpf.id_config_plugin_filter
				LEFT JOIN auth_group ag
					ON cpfg.id_auth_group=ag.id_auth_group
		WHERE cpfg.id_auth_group="'.$f_id_auth_group.'"
		ORDER BY plugin_order';

	$all_plugin_filter_group=$connSQL->getResults($lib);
	$cpt_plugin_filter_group=count($all_plugin_filter_group);
	

	$lib='SELECT 
			* 
		FROM 
			config_plugin_filter
		WHERE 
			id_config_plugin_filter NOT IN (
				SELECT id_config_plugin_filter 
				FROM config_plugin_filter_group
				WHERE id_auth_group="'.$f_id_auth_group.'"
			)
		ORDER BY 
			plugin_filter_desc';
			
	$connSQL=new DB();
	$all_plugin_filter=$connSQL->getResults($lib);
	$cpt_plugin_filter=count($all_plugin_filter);

}
?>