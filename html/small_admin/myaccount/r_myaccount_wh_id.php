<?php
if (isset($_SESSION['S_ID_USER'])) {
	$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);
	
	$connSQL=new DB();
	$lib='SELECT * FROM auth_user WHERE id_auth_user=:s_id_user';
	$connSQL->bind('s_id_user',$s_id_user);
	$cur_user=$connSQL->row($lib);
}
?>
