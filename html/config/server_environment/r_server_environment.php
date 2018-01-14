<?php
if (isset($_GET['f_id_config_server'])) {
    $f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT
            ces.id_config_environment,
            ces.id_config_server,
            ce.environment,
            ce.environment_description,
            cs.server_name,
            cs.server_description
        FROM
            config_environment_server ces
                LEFT JOIN config_environment ce
                    ON ces.id_config_environment=ce.id_config_environment
                LEFT JOIN config_server cs
                    ON ces.id_config_server=cs.id_config_server
        WHERE ces.id_config_server=:f_id_config_server';

    $connSQL->bind('f_id_config_server',$f_id_config_server);
    $all_server_environment=$connSQL->query($lib);
    $cpt_server_environment=count($all_server_environment);


    $connSQL=new DB();
    $lib='SELECT
            *
        FROM
            config_environment
        WHERE
            id_config_environment NOT IN (
                SELECT id_config_environment
                FROM config_environment_server
                WHERE id_config_server=:f_id_config_server
            )
        ORDER BY
            environment_description';

    $connSQL->bind('f_id_config_server',$f_id_config_server);
    $all_environment=$connSQL->query($lib);
    $cpt_environment=count($all_environment);
}
?>
