<?php
if (isset($_POST['f_del_dynamic_dashboard']) && $cur_dynamic_dashboard) {
	
	$f_id_config_dynamic_dashboard=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);

	$connSQL=new DB();
	$connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);

	$lib='DELETE FROM config_dynamic_dashboard_content WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
	$connSQL->query($lib);
	
	$lib='DELETE FROM config_dynamic_dashboard_group WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
	$connSQL->query($lib);
	
	$lib='DELETE FROM config_dynamic_dashboard WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
	$connSQL->query($lib);
}
?>
