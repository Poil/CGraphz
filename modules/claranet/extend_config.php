<?php
$jsonCommun = file_get_contents(DIR_FSROOT."/config/config.json");
$configCommune=json_decode($jsonCommun);

$rrd_cached=$configCommune->rrd_cached;
$CONFIG['list_socket']=array();
foreach($rrd_cached as $name => $r){
    if($name=="default"){
        $CONFIG['socket']=$r;
    }
    $CONFIG['list_socket'][$name]=$r;
}

$plugin=$configCommune->plugin;
$CONFIG['socket_plugin']=array();
foreach($plugin as $name => $rrd_cached_name){
    $CONFIG['socket_plugin'][$name]=$rrd_cached_name;
}

define('CLARATACT_WS','http://claratact.fr.clara.net');
define('CLARATACT_USER','FR-Claratact-API');
define('CLARATACT_PASS','phax5d!idhj8h');
?>
