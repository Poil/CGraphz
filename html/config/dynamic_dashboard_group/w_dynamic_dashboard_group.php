<?php
if (isset($_POST['f_submit_dynamic_dashboard_group'])) {
	
	$f_id_config_dynamic_dashboard=intval($_POST['f_id_config_dynamic_dashboard']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);

	if (isset($_POST['f_group_manager'])!="") {
		$f_group_manager='1';
	} else {
		$f_group_manager='0';
	}

	$lib='INSERT INTO `config_dynamic_dashboard_group` (id_config_dynamic_dashboard,id_auth_group,group_manager) 
		VALUES ("'.$f_id_config_dynamic_dashboard.'","'.$f_id_auth_group.'","'.$f_group_manager.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>