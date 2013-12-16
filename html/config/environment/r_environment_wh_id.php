<?php
if (isset($_GET['f_id_config_environment'])) {
	$f_id_config_environment=filter_input(INPUT_GET,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_environment WHERE id_config_environment=:f_id_config_environment';
	$connSQL->bind('f_id_config_environment',$f_id_config_environment);
	$cur_environment=$connSQL->row($lib);
}
?>
