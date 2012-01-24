<?php
if (isset($_POST['f_delete_group_user'])) {
	$f_id_auth_user=intval($_POST['f_id_auth_user']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	
	$lib='DELETE FROM `auth_user_group` WHERE id_auth_user="'.$f_id_auth_user.'" AND id_auth_group="'.$f_id_auth_group.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}

?>