<?php
if (isset($_GET['f_id_config_dynamic_dashboard']) && isset($_GET['f_id_auth_group'])) {
    $f_id_config_dynamic_dashboard=filter_input(INPUT_GET,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
    $f_id_auth_group=filter_input(INPUT_GET,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT
            cddg.id_config_dynamic_dashboard,
            cddg.id_auth_group,
            cddg.group_manager,
            cdd.`title`,
            ag.`group`,
            ag.group_description
        FROM
            config_dynamic_dashboard_group cddg
                LEFT JOIN config_dynamic_dashboard cdd
                    ON cddg.id_config_dynamic_dashboard=cdd.id_config_dynamic_dashboard
                LEFT JOIN auth_group ag
                    ON cddg.id_auth_group=ag.id_auth_group
        WHERE cddg.id_config_dynamic_dashboard=:f_id_config_dynamic_dashboard
        AND cddg.id_auth_group=:f_id_auth_group';

    $connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);

    $cur_dynamic_dashboard_group=$connSQL->row($lib);

}

?>
