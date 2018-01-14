<?php
if (isset($_GET['f_id_config_server'])) {
    $f_id_config_server=filter_input(INPUT_GET,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);
    $connSQL=new DB();
    if ($module=='dashboard') {
        $lib='SELECT *, COALESCE(collectd_version,"'.COLLECTD_DEFAULT_VERSION.'") as collectd_version FROM config_server WHERE id_config_server=:f_id_config_server';
    } else {
        $lib='SELECT * FROM config_server WHERE id_config_server=:f_id_config_server';
}
    $connSQL->bind('f_id_config_server',$f_id_config_server);
    $cur_server=$connSQL->row($lib);
}
?>
