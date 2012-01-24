<?php
if (isset($_GET['f_id_config_server'])) {
	$f_id_config_server=intval($_GET['f_id_config_server']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_server WHERE id_config_server="'.$f_id_config_server.'"';
	$cur_server=$connSQL->getRow($lib);
}
?>
