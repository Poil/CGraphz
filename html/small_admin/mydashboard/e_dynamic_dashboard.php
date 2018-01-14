<?php
if (isset($_POST['f_del_dynamic_dashboard'])) {
    $f_id_config_dynamic_dashboard=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
    $s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT *
        FROM config_dynamic_dashboard cdd
        LEFT JOIN config_dynamic_dashboard_group cddg
            ON cdd.id_config_dynamic_dashboard=cddg.id_config_dynamic_dashboard
        LEFT JOIN auth_user_group aug
            ON cddg.id_auth_group=aug.id_auth_group
        WHERE cdd.id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard
        AND aug.id_auth_user=:s_id_user';

    $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
    $connSQL->bind('s_id_user',$s_id_user);
    $cur_dynamic_dashboard=$connSQL->row($lib);

    if ($cur_dynamic_dashboard) {
        $connSQL=new DB();

        $lib='DELETE FROM config_dynamic_dashboard_content WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
        $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
        $connSQL->query($lib);

        $lib='DELETE FROM config_dynamic_dashboard_group WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
        $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
        $connSQL->query($lib);

        $lib='DELETE FROM config_dynamic_dashboard WHERE id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard';
        $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
        $connSQL->query($lib);
    }
}
?>
