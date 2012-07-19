<?php
include "modules/preg_find.php";
include "config/config.php";

$plugins = preg_find('/interface\/.*eth0.*/', $CONFIG['datadir'].'/vmhost21g', PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH);
echo "<pre>";
print_r($plugins);
echo "</pre>";
?>
