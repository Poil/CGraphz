<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
    $f_id_config_dynamic_dashboard=filter_input(INPUT_GET,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);

    $all_dynamic_dashboard_content=$connSQL->query('SELECT * FROM config_dynamic_dashboard_content
        WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard ORDER BY dash_ordering');

    $cpt_dynamic_dashboard_content=count($all_dynamic_dashboard_content);


    $all_plugin_filter=$connSQL->query('SELECT * FROM config_plugin_filter ORDER BY plugin_order, plugin_filter_desc');
    $cpt_plugin_filter=count($all_plugin_filter);

}
?>
