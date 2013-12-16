<?php
if (isset($_POST['f_submit_module_group'])) {
	
	$f_id_perm_module=filter_input(INPUT_POST,'f_id_perm_module',FILTER_SANITIZE_NUMBER_INT);
	$f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

	$lib='INSERT INTO perm_module_group
			(id_perm_module, id_auth_group) 
		VALUES 
			(:f_id_perm_module, :f_id_auth_group)';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_perm_module',$f_id_perm_module);
	$connSQL->bind('f_id_auth_group',$f_id_auth_group);
	$connSQL->query($lib);
}
?>
