<?php
$connSQL=new DB();
$all_role=$connSQL->getResults('SELECT * FROM config_role ORDER BY role');
$cpt_role=count($all_role);

?>