<?php
if (isset($_POST['f_submit_environment'])) {

    $f_id_config_environment=filter_input(INPUT_POST,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
    $f_environment=filter_input(INPUT_POST,'f_environment',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_environment_description=filter_input(INPUT_POST,'f_environment_description',FILTER_SANITIZE_SPECIAL_CHARS);

    $connSQL=new DB();
    if ($_POST['f_id_config_environment']) { // UPDATE
        $lib='
            UPDATE config_environment SET
                environment=:f_environment,
                environment_description=:f_environment_description
            WHERE
                id_config_environment=:f_id_config_environment';
    } else { // INSERT
        $lib='INSERT INTO config_environment (id_config_environment,environment,environment_description)
            VALUES (:f_id_config_environment, :f_environment, :f_environment_description)';
    }

    $connSQL->bind('f_id_config_environment',$f_id_config_environment);
    $connSQL->bind('f_environment_description',$f_environment_description);
    $connSQL->bind('f_environment',$f_environment);
    $connSQL->query($lib);
}
?>
