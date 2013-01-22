<?php
$connSQL=new DB();
$all_project=$connSQL->getResults('SELECT * FROM config_project ORDER BY project');
$cpt_project=count($all_project);

?>