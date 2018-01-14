<?php
if (isset($_POST['f_delete_dynamic_dashboard_group'])) {
    $f_id_config_dynamic_dashboard=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    $lib='DELETE FROM config_dynamic_dashboard_group WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard AND id_auth_group=:f_id_auth_group';

    $connSQL=new DB();
    $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $connSQL->query($lib);
}

?>
