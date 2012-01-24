<?php
if (isset($_GET['f_id_auth_user'])) {
	$f_id_auth_user=intval($_GET['f_id_auth_user']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM auth_user WHERE id_auth_user="'.$f_id_auth_user.'"';
	$cur_user=$connSQL->getRow($lib);
}
?>