<?php
$connSQL=new DB();
$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

$lib='SELECT cdd.*
    FROM config_dynamic_dashboard cdd
    LEFT JOIN config_dynamic_dashboard_group cddg
        ON cdd.id_config_dynamic_dashboard=cddg.id_config_dynamic_dashboard
    LEFT JOIN auth_user_group aug
        ON cddg.id_auth_group=aug.id_auth_group
    WHERE aug.id_auth_user=:s_id_user
    AND cddg.group_manager=1
    GROUP BY cdd.title
    ORDER BY cdd.title';

$connSQL->bind('s_id_user',$s_id_user);

$all_dynamic_dashboard=$connSQL->query($lib);
$cpt_dynamic_dashboard=count($all_dynamic_dashboard);
?>
