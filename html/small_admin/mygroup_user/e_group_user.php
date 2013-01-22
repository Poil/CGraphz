<?php
if (isset($_POST['f_delete_group_user'])) {
	$f_id_auth_user=intval($_POST['f_id_auth_user']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	
	$connSQL=new DB();
	
	$lib='DELETE FROM `auth_user_group` WHERE id_auth_user="'.$f_id_auth_user.'" AND id_auth_group="'.$f_id_auth_group.'"';
	$connSQL->query($lib);
	
	// Si on a plus d'utilisateur dans le groupe on le supprime
	$lib='SELECT count(*) as mycpt FROM `auth_user_group` WHERE id_auth_group="'.$f_id_auth_group.'"';
	$res=$connSQL->getRow($lib);
	
	if ($res->mycpt == 0) {
		$lib='DELETE FROM `config_plugin_filter_group` WHERE  id_auth_group="'.$f_id_auth_group.'"';
		$connSQL->query($lib);
		
		$lib='DELETE FROM `perm_module_group` WHERE  id_auth_group="'.$f_id_auth_group.'"';
		$connSQL->query($lib);
		
		$lib='DELETE FROM `perm_project_group` WHERE  id_auth_group="'.$f_id_auth_group.'"';
		$connSQL->query($lib);
		
		$lib='DELETE FROM `auth_group` WHERE id_auth_group="'.$f_id_auth_group.'"';
		$connSQL->query($lib);
	}
}

?>