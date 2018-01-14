<?php
if (isset($_POST['f_submit_server_environment'])) {

    $f_id_config_environment=filter_input(INPUT_POST,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
    $f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);

    $lib='INSERT INTO config_environment_server
            (id_config_environment, id_config_server)
        VALUES
            (:f_id_config_environment, :f_id_config_server)';

    $connSQL=new DB();
    $connSQL->bind('f_id_config_environment',$f_id_config_environment);
    $connSQL->bind('f_id_config_server',$f_id_config_server);
    $connSQL->query($lib);
}
?>
