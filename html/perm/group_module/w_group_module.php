<?php
if (isset($_POST['f_submit_group_module'])) {
	
	$f_id_perm_module=intval($_POST['f_id_perm_module']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);

	$lib='INSERT INTO `perm_module_group` 
			(`id_perm_module`,`id_auth_group`) 
		VALUES 
			("'.$f_id_perm_module.'","'.$f_id_auth_group.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
