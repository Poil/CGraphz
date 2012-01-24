<?php
if (isset($_POST['f_del_user'])) {
	
	$f_id_auth_user=intval($_POST['f_id_auth_user']);

	$lib='DELETE FROM `auth_user` WHERE id_auth_user="'.$f_id_auth_user.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
