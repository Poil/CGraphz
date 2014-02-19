<?php
if (isset($_GET['f_id_perm_module'])) {
	$f_id_perm_module=filter_input(INPUT_GET,'f_id_perm_module',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$connSQL->bind('f_id_perm_module',$f_id_perm_module);
	$lib='SELECT * FROM perm_module WHERE id_perm_module=:f_id_perm_module';
	$cur_module=$connSQL->row($lib);
}
?>
