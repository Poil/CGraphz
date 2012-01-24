<?php
if (isset($_POST['f_submit_project_group'])) {
	
	$f_id_config_project=intval($_POST['f_id_config_project']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);

	$lib='INSERT INTO `perm_project_group` 
			(`id_config_project`,`id_auth_group`) 
		VALUES 
			("'.$f_id_config_project.'","'.$f_id_auth_group.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
