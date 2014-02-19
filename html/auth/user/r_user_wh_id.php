<?php
if (isset($_GET['f_id_auth_user'])) {
	$f_id_auth_user=filter_input(INPUT_GET,'f_id_auth_user',FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$lib='SELECT * FROM auth_user WHERE id_auth_user=:f_id_auth_user';
	$connSQL->bind('f_id_auth_user',$f_id_auth_user);
	$cur_user=$connSQL->row($lib);
}
?>
