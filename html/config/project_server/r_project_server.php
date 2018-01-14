<?php
if (isset($_GET['f_id_config_project'])) {
    $f_id_config_project=filter_input(INPUT_GET,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT
            csp.id_config_project,
            csp.id_config_server,
            cp.project,
            cs.server_name,
            cs.server_description
        FROM
            config_server_project csp
                LEFT JOIN config_project cp
                    ON csp.id_config_project=cp.id_config_project
                LEFT JOIN config_server cs
                    ON csp.id_config_server=cs.id_config_server
        WHERE csp.id_config_project=:f_id_config_project';

    $connSQL->bind('f_id_config_project',$f_id_config_project);
    $all_project_server=$connSQL->query($lib);
    $cpt_project_server=count($all_project_server);

    $connSQL=new DB();
    if ($f_filter_server_in_project!='true') {
        $lib='SELECT
            *
        FROM
            config_server
        WHERE
            id_config_server NOT IN (
                SELECT id_config_server
                FROM config_server_project
                WHERE id_config_project=:f_id_config_project
            )
        ORDER BY
            server_name';
        $connSQL->bind('f_id_config_project',$f_id_config_project);
    } else {
        $lib='SELECT
            *
        FROM
            config_server
        WHERE
            id_config_server NOT IN (
                SELECT id_config_server
                FROM config_server_project
            )
        ORDER BY
            server_name';
        }
    $all_server=$connSQL->query($lib);
    $cpt_server=count($all_server);
}
?>
