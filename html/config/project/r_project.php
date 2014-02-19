<?php
$connSQL=new DB();
$all_project=$connSQL->query('SELECT * FROM config_project ORDER BY project');
$cpt_project=count($all_project);

?>
