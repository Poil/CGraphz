<?php
$connSQL=new DB();
$all_dynamic_dashboard=$connSQL->getResults('SELECT * FROM config_dynamic_dashboard ORDER BY title');
$cpt_dynamic_dashboard=count($all_dynamic_dashboard);
?>