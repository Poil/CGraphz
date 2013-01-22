<?php
if (isset($_POST['f_submit_user'])) {
	
	$f_nom=mysql_escape_string(filter_input(INPUT_POST,'f_nom',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_prenom=mysql_escape_string(filter_input(INPUT_POST,'f_prenom',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_user=mysql_escape_string(filter_input(INPUT_POST,'f_user',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_mail=mysql_escape_string(filter_input(INPUT_POST,'f_mail',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_passwd=mysql_escape_string($_POST['f_passwd']);
	$f_type=mysql_escape_string(filter_input(INPUT_POST,'f_type',FILTER_SANITIZE_SPECIAL_CHARS));
		
		
	$lib='INSERT INTO `auth_user` (
			`nom`,
			`prenom`,
			`user`, 
			`mail`, 
			`passwd`,
			`type`
		) 
		VALUES (
			"'.$f_nom.'",
			"'.$f_prenom.'",
			"'.$f_user.'",
			"'.$f_mail.'",
			PASSWORD("'.$f_passwd.'"),
			"'.$f_type.'"
		)';
	
	$connSQL=new DB();
	$connSQL->query($lib);
	
	echo 'L\'Utilisateur '.$f_user.' a été créé<br />';
}
?>