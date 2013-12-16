<?php
if (isset($_POST['f_del_module'])) {
	$f_id_perm_module=filter_input(INPUT_POST,'f_id_perm_module',FILTER_SANITIZE_NUMBER_INT);

	$lib='DELETE FROM perm_module WHERE id_perm_module=:f_id_perm_module';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_perm_module',$f_id_perm_module);
	$connSQL->query($lib);
}
?>
