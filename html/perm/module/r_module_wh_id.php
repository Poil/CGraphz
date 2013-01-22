<?php
if (isset($_GET['f_id_perm_module'])) {
	$f_id_perm_module=intval($_GET['f_id_perm_module']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM perm_module WHERE id_perm_module="'.$f_id_perm_module.'"';
	$cur_module=$connSQL->getRow($lib);
}
?>
