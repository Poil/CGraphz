<?php
if (isset($_POST['f_submit_group_user'])) {
	
	$f_id_auth_user=intval($_POST['f_id_auth_user']);
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	if(isset($_POST['f_manager'])!="") {
		$f_manager='1';
	} else {
		$f_manager='0';
	}

	$lib='REPLACE INTO `auth_user_group` (`id_auth_user`,`id_auth_group`,`manager`) VALUES ("'.$f_id_auth_user.'","'.$f_id_auth_group.'","'.$f_manager.'")';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>