<?php
if (isset($_POST['f_delete_group_user'])) {
	$f_id_auth_user=filter_input(INPUT_POST,'f_id_auth_user',FILTER_SANITIZE_NUMBER_INT);
	$f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	
	$connSQL->bind('f_id_auth_user',$f_id_auth_user);
	$connSQL->bind('f_id_auth_grouo',$f_id_auth_group);
	$lib='DELETE FROM auth_user_group WHERE id_auth_user=:f_id_auth_user AND id_auth_group=:f_id_auth_group';
	$connSQL->query($lib);
	
	// If no more user in cur group then delete it
	$lib='SELECT count(*) as mycpt FROM auth_user_group WHERE id_auth_group=:f_id_auth_group';
	$res=$connSQL->row($lib);
	
	if ($res->mycpt == 0) {
		$lib='DELETE FROM config_plugin_filter_group WHERE id_auth_group=:f_id_auth_group';
		$connSQL->query($lib);
		
		$lib='DELETE FROM perm_module_group WHERE  id_auth_group=:f_id_auth_group';
		$connSQL->query($lib);
		
		$lib='DELETE FROM perm_project_group WHERE  id_auth_group=:f_id_auth_group';
		$connSQL->query($lib);
		
		$lib='DELETE FROM auth_group WHERE id_auth_group=:$f_id_auth_group';
		$connSQL->query($lib);
	}
}

?>
