<?php
if (isset($_POST['f_submit_group'])) {
	$f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
	$f_group_description=filter_input(INPUT_POST,'f_group_description',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_group=filter_input(INPUT_POST,'f_group',FILTER_SANITIZE_SPECIAL_CHARS);
		
	$connSQL=new DB();
	if ($_POST['f_id_auth_group']) { // UPDATE
		$connSQL->bind('f_id_auth_group',$f_id_auth_group);
		$lib='
			UPDATE auth_group ag SET
				ag.group=:f_group,
				ag.group_description=:f_group_description
			WHERE
				ag.id_auth_group=:f_id_auth_group';
	} else { // INSERT
		$lib='INSERT INTO auth_group ag (
				ag.group, 
				ag.group_description
			) 
			VALUES (
				:f_group,
				:f_group_description
			)';
	}
	
	$connSQL->bind('f_group_description',$f_group_description);
	$connSQL->bind('f_group',$f_group);
	$connSQL->query($lib);
}
?>
