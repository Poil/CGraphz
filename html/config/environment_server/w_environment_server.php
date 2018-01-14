<?php
if (isset($_POST['f_submit_environment_server'])) {

    $f_id_config_environment=filter_input(INPUT_POST,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
    $f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
    $f_filter_server_in_environment=filter_input(INPUT_POST,'f_filter_server_in_environment',FILTER_SANITIZE_SPECIAL_CHARS);

    if ($f_id_config_server) {
        foreach ($f_id_config_server as $id_config_server) {
            $lib='INSERT INTO config_environment_server
                    (id_config_environment,id_config_server)
                VALUES
                    (:f_id_config_environment,:id_config_server)';

            $connSQL=new DB();
            $connSQL->bind('f_id_config_environment',$f_id_config_environment);
            $connSQL->bind('id_config_server',$id_config_server);
            $connSQL->query($lib);
        }
    }
} else {
    $f_filter_server_in_environment='true';
}
?>
