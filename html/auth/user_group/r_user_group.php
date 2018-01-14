<?php
if (isset($_GET['f_id_auth_user'])) {
    $f_id_auth_user=filter_input(INPUT_GET,'f_id_auth_user',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT
            aug.id_auth_user,
            aug.id_auth_group,
            aug.manager,
            au.user,
            ag.group,
            ag.group_description
        FROM
            auth_user_group aug
                LEFT JOIN auth_user au
                    ON aug.id_auth_user=au.id_auth_user
                LEFT JOIN auth_group ag
                    ON aug.id_auth_group=ag.id_auth_group
        WHERE aug.id_auth_user=:f_id_auth_user';

    $connSQL->bind('f_id_auth_user',$f_id_auth_user);
    $all_user_group=$connSQL->query($lib);
    $cpt_user_group=count($all_user_group);


    $lib='SELECT
            *
        FROM
            auth_group ag
        WHERE
            id_auth_group NOT IN (
                SELECT id_auth_group
                FROM auth_user_group
                WHERE id_auth_user=:f_id_auth_user
            )
        ORDER BY
            ag.group';

    $connSQL=new DB();
    $connSQL->bind('f_id_auth_user',$f_id_auth_user);
    $all_group=$connSQL->query($lib);
    $cpt_group=count($all_group);
}
?>
