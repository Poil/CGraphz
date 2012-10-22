<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
	$f_id_config_dynamic_dashboard=intval($_GET['f_id_config_dynamic_dashboard']);
	
	$connSQL=new DB();
	$lib='SELECT * 
		FROM config_dynamic_dashboard cdd
		LEFT JOIN config_dynamic_dashboard_group cddg
			ON cdd.id_config_dynamic_dashboard=cddg.id_config_dynamic_dashboard
		LEFT JOIN auth_user_group aug
			ON cddg.id_auth_group=aug.id_auth_group 
		WHERE cdd.id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"
		AND aug.id_auth_user='.intval($_SESSION['S_ID_USER']);
		
	$cur_dynamic_dashboard=$connSQL->getRow($lib);
}
?>
