<?php
if (isset($_SESSION['S_ID_USER'])) {
	$f_id_auth_user=intval($_SESSION['S_ID_USER']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM auth_user WHERE id_auth_user="'.$f_id_auth_user.'"';
	$cur_user=$connSQL->getRow($lib);
}
?>