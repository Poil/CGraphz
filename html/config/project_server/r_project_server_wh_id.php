<?php
if (isset($_GET['f_id_config_project']) && isset($_GET['f_id_config_server'])) {
    $f_id_config_project=filter_input(INPUT_GET,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
    $f_id_config_server=filter_input(INPUT_GET,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    /* A FAIRE A PARTIR D'ICI DEMAIN GROS BOULET */
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
        WHERE csp.id_config_project=:f_id_config_project
        AND csp.id_config_server=:f_id_config_server';

    $connSQL->bind('f_id_config_project',$f_id_config_project);
    $connSQL->bind('f_id_config_server',$f_id_config_server);
    $cur_project_server=$connSQL->row($lib);
}
?>
