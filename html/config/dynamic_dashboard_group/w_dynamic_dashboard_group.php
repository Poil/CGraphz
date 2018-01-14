<?php
if (isset($_POST['f_submit_dynamic_dashboard_group'])) {
    $f_id_config_dynamic_dashboard=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    if (isset($_POST['f_group_manager'])!="") {
        $f_group_manager='1';
    } else {
        $f_group_manager='0';
    }

    $lib='INSERT INTO `config_dynamic_dashboard_group` (id_config_dynamic_dashboard,id_auth_group,group_manager)
        VALUES (:f_id_config_dynamic_dashboard, :f_id_auth_group, :f_group_manager)';

    $connSQL=new DB();
    $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $connSQL->bind('f_group_manager',$f_group_manager);
    $connSQL->query($lib);
}
?>
