<?php
$connSQL=new DB();
$all_user=$connSQL->getResults('SELECT * FROM auth_user ORDER BY nom, prenom, mail');
$cpt_user=count($all_user);
?>