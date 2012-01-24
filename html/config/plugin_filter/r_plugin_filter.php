<?php
$connSQL=new DB();
$all_plugin_filter=$connSQL->getResults('SELECT * FROM config_plugin_filter ORDER BY plugin_order, plugin_filter_desc');
$cpt_plugin_filter=count($all_plugin_filter);

?>