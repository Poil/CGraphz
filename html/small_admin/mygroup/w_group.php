<?php
if (isset($_POST['f_submit_group'])) {
	
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	$f_group_description=mysql_escape_string($_POST['f_group_description']);
	$f_group=mysql_escape_string($_POST['f_group']);		
		
	$perm_grp = new PERMS();
	if (($f_id_auth_group && $perm_grp->auth_user_group($_SESSION['S_ID_USER'],$f_id_auth_group,true)) || !$f_id_auth_group) {
		$connSQL=new DB();
		
		if ($_POST['f_id_auth_group']) { // UPDATE
			$lib='
				UPDATE `auth_group` SET
					`group`="'.$f_group.'",
					`group_description`="'.$f_group_description.'"
				WHERE
					`id_auth_group`="'.$f_id_auth_group.'"';
					
			
			$connSQL->query($lib);
		} else { // INSERT
			$lib='INSERT INTO `auth_group` (
					`group`, 
					`group_description`
				) 
				VALUES (
					"'.$f_group.'",
					"'.$f_group_description.'"
				)';
			$connSQL->query($lib);
			$id_auth_group=$connSQL->getLastInsertId();
			$lib='INSERT INTO `auth_user_group` (
					`id_auth_user`,
					`id_auth_group`,
					`manager`
				 ) VALUES (
					"'.$_SESSION['S_ID_USER'].'",
					"'.$id_auth_group.'",
					"1"
				)';
			$connSQL->query($lib);
		}
	} else {
		echo 'Vilain';
	}
}
?>