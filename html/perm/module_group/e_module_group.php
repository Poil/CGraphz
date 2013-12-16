<?php
if (isset($_POST['f_delete_module_group'])) {
	$f_id_perm_module=filter_input(INPUT_POST,'f_id_perm_module',FILTER_SANITIZE_NUMBER_INT);
	$f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
	
	$lib='DELETE FROM perm_module_group WHERE id_perm_module=:f_id_perm_module AND id_auth_group=:f_id_auth_group';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_perm_module',$f_id_perm_module);
	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$connSQL->query($lib);
}

?>
