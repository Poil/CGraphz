<?php
if (isset($_POST['f_del_group'])) {
	
	$f_id_auth_group=intval($_POST['f_id_auth_group']);

	$lib='DELETE FROM `auth_group` WHERE id_auth_group="'.$f_id_auth_group.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
