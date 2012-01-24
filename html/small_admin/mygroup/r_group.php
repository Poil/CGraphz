<?php
$connSQL=new DB();
$all_group=$connSQL->getResults('SELECT * FROM auth_group WHERE id_auth_group IN (SELECT id_auth_group FROM auth_user_group WHERE id_auth_user='.intval($_SESSION['S_ID_USER']).' AND manager=1) ORDER BY `group`');
$cpt_group=count($all_group);
?>