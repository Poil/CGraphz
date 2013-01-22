<?php
if (isset($_POST['f_del_dynamic_dashboard_content']) && $cur_dynamic_dashboard) {
	
	$f_id_config_dynamic_dashboard_content=intval($_POST['f_id_config_dynamic_dashboard_content']);

	$lib='DELETE FROM config_dynamic_dashboard_content WHERE id_config_dynamic_dashboard_content="'.$f_id_config_dynamic_dashboard_content.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
