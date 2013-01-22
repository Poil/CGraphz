<?php
if (isset($_POST['f_delete_dynamic_dashboard_group'])) {
	$f_id_config_dynamic_dashboard=intval($_POST['f_id_config_dynamic_dashboard']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	
	$lib='DELETE FROM config_dynamic_dashboard_group WHERE id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'" AND id_auth_group="'.$f_id_auth_group.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>