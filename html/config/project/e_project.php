<?php
if (isset($_POST['f_del_project'])) {
	
	$f_id_config_project=intval($_POST['f_id_config_project']);

	$lib='DELETE FROM `config_project` WHERE id_config_project="'.$f_id_config_project.'"';
	
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
