<?php
if (isset($_POST['f_delete_group_user'])) {
	$f_id_auth_user=filter_input(INPUT_POST,'f_id_auth_user',FILTER_SANITIZE_NUMBER_INT);
	$f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
	
	$lib='DELETE FROM auth_user_group WHERE id_auth_user=:f_id_auth_user AND id_auth_group=:f_id_auth_group';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_auth_user',$f_id_auth_user);
	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$connSQL->query($lib);
}

?>
