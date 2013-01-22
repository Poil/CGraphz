<?php
if (isset($_POST['f_del_dynamic_dashboard']) && $cur_dynamic_dashboard) {
	
	$f_id_config_dynamic_dashboard=intval($_POST['f_id_config_dynamic_dashboard']);

	$connSQL=new DB();

	$lib='DELETE FROM `config_dynamic_dashboard_content` WHERE id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';
	$connSQL->query($lib);
	
	$lib='DELETE FROM `config_dynamic_dashboard_group` WHERE id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';
	$connSQL->query($lib);
	
	$lib='DELETE FROM `config_dynamic_dashboard` WHERE id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';
	$connSQL->query($lib);
}
?>
