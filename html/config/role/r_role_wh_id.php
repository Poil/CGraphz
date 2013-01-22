<?php
if (isset($_GET['f_id_config_role'])) {
	$f_id_config_role=intval($_GET['f_id_config_role']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_role WHERE id_config_role="'.$f_id_config_role.'"';
	$cur_role=$connSQL->getRow($lib);
}
?>
