<?php
if (isset($_POST['f_delete_role_server'])) {
    $f_id_config_role=filter_input(INPUT_POST,'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);
    $f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);

    $lib='DELETE FROM config_role_server WHERE id_config_role=:f_id_config_role AND id_config_server=:f_id_config_server';

    $connSQL=new DB();
    $connSQL->bind('f_id_config_role', $f_id_config_role);
    $connSQL->bind('f_id_config_server', $f_id_config_server);
    $connSQL->query($lib);
}

?>
