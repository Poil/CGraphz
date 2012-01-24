<?php
if (isset($_POST['f_submit_module'])) {
	
	$f_id_perm_module=intval($_POST['f_id_perm_module']);
	$f_module=mysql_escape_string($_POST['f_module']);
	$f_component=mysql_escape_string($_POST['f_component']);
	$f_menu_name=mysql_escape_string($_POST['f_menu_name']);
	$f_menu_order=intval($_POST['f_menu_order']);
		
	if ($_POST['f_id_perm_module']) { // UPDATE
		$lib='
			UPDATE `perm_module` SET
				`module`="'.$f_module.'",
				`component`="'.$f_component.'",
				`menu_name`="'.$f_menu_name.'",
				`menu_order`="'.$f_menu_order.'"
			WHERE
				`id_perm_module`="'.$f_id_perm_module.'"';
	} else { // INSERT
		$lib='INSERT INTO `perm_module` (`id_perm_module`,`module`,`component`,`menu_name`,`menu_order`) VALUES ("'.$f_id_perm_module.'","'.$f_module.'","'.$f_component.'","'.$f_menu_name.'","'.$f_menu_order.'")';
	}
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
