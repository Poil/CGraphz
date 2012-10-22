<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
	$f_id_config_dynamic_dashboard=intval($_GET['f_id_config_dynamic_dashboard']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_dynamic_dashboard WHERE id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';
	$cur_dynamic_dashboard=$connSQL->getRow($lib);
}
?>
