<?php
if (isset($_GET['f_id_perm_module'])) {
    $f_id_perm_module=filter_input(INPUT_GET,'f_id_perm_module',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT
            pmg.id_perm_module,
            pmg.id_auth_group,
            pm.module,
            ag.group,
            ag.group_description
        FROM
            perm_module_group pmg
                LEFT JOIN perm_module pm
                    ON pmg.id_perm_module=pm.id_perm_module
                LEFT JOIN auth_group ag
                    ON pmg.id_auth_group=ag.id_auth_group
        WHERE pmg.id_perm_module=:f_id_perm_module';

    $connSQL->bind('f_id_perm_module',$f_id_perm_module);
    $all_module_group=$connSQL->query($lib);
    $cpt_module_group=count($all_module_group);


    $lib='SELECT
            *
        FROM
            auth_group ag
        WHERE
            ag.id_auth_group NOT IN (
                SELECT id_auth_group
                FROM perm_module_group
                WHERE id_perm_module=:f_id_perm_module
            )
        ORDER BY
            ag.group';

    $connSQL=new DB();
    $connSQL->bind('f_id_perm_module',$f_id_perm_module);
    $all_group=$connSQL->query($lib);
    $cpt_group=count($all_group);
}
?>
