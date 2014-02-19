<?php
$connSQL=new DB();
$all_user=$connSQL->query('SELECT * FROM auth_user ORDER BY nom, prenom, mail');
$cpt_user=count($all_user);
?>
