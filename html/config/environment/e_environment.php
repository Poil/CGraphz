<?php
if (isset($_POST['f_del_environment'])) {
	
	$f_id_config_environment=intval($_POST['f_id_config_environment']);

	$lib='DELETE FROM `config_environment` WHERE id_config_environment="'.$f_id_config_environment.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
