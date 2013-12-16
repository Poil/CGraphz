<?php
if (isset($_POST['f_del_environment'])) {
	
	$f_id_config_environment=filter_input(INPUT_POST,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);

	$lib='DELETE FROM config_environment WHERE id_config_environment=:f_id_config_environment';
	
	$connSQL=new DB();
	$connSQL->bind('f_id_config_environment',$f_id_config_environment);
	$connSQL->query($lib);
}
?>
