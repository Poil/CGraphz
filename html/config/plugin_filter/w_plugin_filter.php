<?php
if (isset($_POST['f_submit_plugin_filter'])) {
	
	$f_id_config_plugin_filter=filter_input(INPUT_POST,'f_id_config_plugin_filter',FILTER_SANITIZE_NUMBER_INT);
	$f_plugin_filter_desc=filter_input(INPUT_POST,'f_plugin_filter_desc',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_plugin_filter_p=filter_input(INPUT_POST,'f_plugin_filter_p',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_plugin_filter_pi=filter_input(INPUT_POST,'f_plugin_filter_pi',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_plugin_filter_t=filter_input(INPUT_POST,'f_plugin_filter_t',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_plugin_filter_ti=filter_input(INPUT_POST,'f_plugin_filter_ti',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_plugin_filter_plugin_order=filter_input(INPUT_POST,'f_plugin_filter_plugin_order',FILTER_SANITIZE_NUMBER_INT);
		
	$connSQL=new DB();
	if ($_POST['f_id_config_plugin_filter']) { // UPDATE
		$lib='
			UPDATE config_plugin_filter SET
				plugin_filter_desc=:f_plugin_filter_desc,
				plugin=:f_plugin_filter_p,
				plugin_instance=:f_plugin_filter_pi,
				type=:f_plugin_filter_t,
				type_instance=:f_plugin_filter_ti,
				plugin_order=:f_plugin_filter_plugin_order
			WHERE
				id_config_plugin_filter=:f_id_config_plugin_filter';
	} else { // INSERT
		$lib='INSERT INTO config_plugin_filter (id_config_plugin_filter, plugin_filter_desc,plugin, plugin_instance, type, type_instance, plugin_order) 
			  VALUES (:f_id_config_plugin_filter, :f_plugin_filter_desc, :f_plugin_filter_p,
				:f_plugin_filter_pi, :f_plugin_filter_t, :f_plugin_filter_ti, :f_plugin_filter_plugin_order)';
	}
	$connSQL->bind('f_plugin_filter_desc',$f_plugin_filter_desc);
	$connSQL->bind('f_plugin_filter_p',$f_plugin_filter_p);
	$connSQL->bind('f_plugin_filter_pi',$f_plugin_filter_pi);
	$connSQL->bind('f_plugin_filter_t',$f_plugin_filter_t);
	$connSQL->bind('f_plugin_filter_ti',$f_plugin_filter_ti);
	$connSQL->bind('f_plugin_filter_plugin_order',$f_plugin_filter_plugin_order);
	$connSQL->bind('f_id_config_plugin_filter',$f_id_config_plugin_filter);
	
	$connSQL->query($lib);
}
?>
