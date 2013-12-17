<?php
if (isset($_POST['f_del_role'])) {
	$f_id_config_role=filter_input(INPUT_POST,'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);
	
	$lib='DELETE FROM config_role_server WHERE id_config_role=:f_id_config_role';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_role', $f_id_config_role);
	$connSQL->query($lib);
}

?>

