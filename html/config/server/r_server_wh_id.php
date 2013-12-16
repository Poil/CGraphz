<?php
if (isset($_GET['f_id_config_server'])) {
	$f_id_config_server=filter_input(INPUT_GET,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_server WHERE id_config_server=:f_id_config_server';
	$connSQL->bind('f_id_config_server',$f_id_config_server);
	$cur_server=$connSQL->row($lib);
}
?>
