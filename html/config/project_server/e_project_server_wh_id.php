<?php
if (isset($_POST['f_del_project'])) {
    $f_id_config_project=filter_input(INPUT_POST,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);

    $lib='DELETE FROM config_server_project WHERE id_config_project=:f_id_config_project';

    $connSQL=new DB();
    $connSQL->bind('f_id_config_project',$f_id_config_project);
    $connSQL->query($lib);
}

?>
