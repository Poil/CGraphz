<?php
if (isset($_POST['f_delete_project_group'])) {
	$f_id_config_project=intval($_POST['f_id_config_project']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	
	$lib='DELETE FROM `perm_project_group` WHERE id_config_project="'.$f_id_config_project.'" AND id_auth_group="'.$f_id_auth_group.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>
