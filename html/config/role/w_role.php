<?php
if (isset($_POST['f_submit_role'])) {
	$f_id_config_role=filter_input(INPUT_POST,'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);
	$f_role=filter_input(INPUT_POST,'f_role',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_role_description=filter_input(INPUT_POST,'f_role_description',FILTER_SANITIZE_SPECIAL_CHARS);
		
	if ($_POST['f_id_config_role']) { // UPDATE
		$lib='
			UPDATE config_role SET
				role=:f_role,
				role_description=:f_role_description
			WHERE
				id_config_role=:f_id_config_role';
	} else { // INSERT
		$lib='INSERT INTO config_role (id_config_role,role,role_description) 
			VALUES (:f_id_config_role, :f_role, :f_role_description)';
	}
	
	$connSQL=new DB();
	$connSQL->bind('f_role',$f_role);
	$connSQL->bind('f_role_description',$f_role_description);
	$connSQL->bind('f_id_config_role',$f_id_config_role);
	$connSQL->query($lib);
}
?>
