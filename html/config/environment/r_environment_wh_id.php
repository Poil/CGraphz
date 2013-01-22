<?php
if (isset($_GET['f_id_config_environment'])) {
	$f_id_config_environment=intval($_GET['f_id_config_environment']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_environment WHERE id_config_environment="'.$f_id_config_environment.'"';
	$cur_environment=$connSQL->getRow($lib);
}
?>
