<?php
if (isset($_POST['f_del_server'])) {
	
	$f_id_config_server=intval($_POST['f_id_config_server']);

	$lib='DELETE FROM `config_server` WHERE id_config_server="'.$f_id_config_server.'"';

	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
