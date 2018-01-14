<?php
if ($_GET['f_id_auth_group']) {
    $f_id_auth_group=filter_input(INPUT_GET,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

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
        WHERE aug.id_auth_group=:f_id_auth_group';

    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $all_group_user=$connSQL->query($lib);
    $cpt_group_user=count($all_group_user);


    $lib='SELECT
            *
        FROM
            auth_user
        WHERE
            id_auth_user NOT IN (
                SELECT id_auth_user
                FROM auth_user_group
                WHERE id_auth_group=:f_id_auth_group
            )
        ORDER BY
            nom,
            prenom,
            mail';

    $connSQL=new DB();
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $all_user=$connSQL->query($lib);
    $cpt_user=count($all_user);

}
?>
