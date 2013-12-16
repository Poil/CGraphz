<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
	$f_id_config_dynamic_dashboard=filter_input(INPUT_GET,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_dynamic_dashboard WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
	$connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
	$cur_dynamic_dashboard=$connSQL->row($lib);
}
?>
