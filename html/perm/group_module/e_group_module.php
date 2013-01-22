<?php
if (isset($_POST['f_delete_group_module'])) {
	$f_id_perm_module=intval($_POST['f_id_perm_module']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	
	$lib='DELETE FROM `perm_module_group` WHERE id_perm_module="'.$f_id_perm_module.'" AND id_auth_group="'.$f_id_auth_group.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>
