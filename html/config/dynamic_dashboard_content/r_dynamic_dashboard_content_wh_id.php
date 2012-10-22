<?php
if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
	$f_id_config_dynamic_dashboard_content=intval($_GET['f_id_config_dynamic_dashboard_content']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_dynamic_dashboard_content WHERE id_config_dynamic_dashboard_content="'.$f_id_config_dynamic_dashboard_content.'"';
	$cur_dynamic_dashboard_content=$connSQL->getRow($lib);
}
?>
