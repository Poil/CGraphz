<?php
if (isset($_POST['f_del_module'])) {
	
	$f_id_perm_module=intval($_POST['f_id_perm_module']);

	$lib='DELETE FROM `perm_module` WHERE id_perm_module="'.$f_id_perm_module.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
