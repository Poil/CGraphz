<?php
$connSQL=new DB();
$all_environment=$connSQL->getResults('SELECT * FROM config_environment ORDER BY environment');
$cpt_environment=count($all_environment);

?>