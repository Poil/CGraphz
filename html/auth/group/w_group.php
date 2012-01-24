<?php
if (isset($_POST['f_submit_group'])) {
	
	$f_id_auth_group=intval($_POST['f_id_auth_group']);
	$f_group_description=mysql_escape_string($_POST['f_group_description']);
	$f_group=mysql_escape_string($_POST['f_group']);
		
	if ($_POST['f_id_auth_group']) { // UPDATE
		$lib='
			UPDATE `auth_group` SET
				`group`="'.$f_group.'",
				`group_description`="'.$f_group_description.'"
			WHERE
				`id_auth_group`="'.$f_id_auth_group.'"';
	} else { // INSERT
		$lib='INSERT INTO `auth_group` (
				`group`, 
				`group_description`
			) 
			VALUES (
				"'.$f_group.'",
				"'.$f_group_description.'"
			)';
	}
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>