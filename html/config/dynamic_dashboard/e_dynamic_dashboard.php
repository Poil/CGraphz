<?php
if (isset($_POST['f_del_dynamic_dashboard'])) {
	
	$f_id_config_dynamic_dashboard=intval($_POST['f_id_config_dynamic_dashboard']);

	$lib='DELETE FROM `config_dynamic_dashboard` WHERE id_config_dynamic_dashboard="'.$f_id_config_dynamic_dashboard.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
