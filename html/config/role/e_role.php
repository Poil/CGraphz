<?php
if (isset($_POST['f_del_role'])) {
	
	$f_id_config_role=intval($_POST['f_id_config_role']);

	$lib='DELETE FROM `config_role` WHERE id_config_role="'.$f_id_config_role.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
