<?php
if (isset($_GET['f_id_config_environment']) && isset($_GET['f_id_config_server'])) {
    $f_id_config_environment=filter_input(INPUT_GET,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
    $f_id_config_server=filter_input(INPUT_GET,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT
            ces.id_config_environment,
            ces.id_config_server,
            ce.environment,
            ce.environment_description
        FROM
            config_environment_server ces
                LEFT JOIN config_environment ce
                    ON ces.id_config_environment=ce.id_config_environment
                LEFT JOIN config_server cs
                    ON ces.id_config_server=cs.id_config_server
        WHERE ces.id_config_environment=:f_id_config_environment
        AND ces.id_config_server=:f_id_config_server';

    $connSQL->bind('f_id_config_environment',$f_id_config_environment);
    $connSQL->bind('f_id_config_server',$f_id_config_server);
    $cur_server_environment=$connSQL->row($lib);
}
?>
