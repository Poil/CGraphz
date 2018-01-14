<?php
if (isset($_POST['f_del_group'])) {
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    $lib='DELETE FROM config_plugin_filter_group WHERE id_auth_group=:f_id_auth_group';

    $connSQL=new DB();
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $connSQL->query($lib);
}

?>

