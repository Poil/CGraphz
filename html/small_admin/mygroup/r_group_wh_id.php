<?php
if (isset($_GET['f_id_auth_group'])) {
	$f_id_auth_group=intval($_GET['f_id_auth_group']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM auth_group WHERE id_auth_group="'.$f_id_auth_group.'"';
	$cur_group=$connSQL->getRow($lib);
}
?>