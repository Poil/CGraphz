<?php
$connSQL=new DB();
$all_group=$connSQL->query('SELECT * FROM auth_group ag ORDER BY ag.group');
$cpt_group=count($all_group);
?>
