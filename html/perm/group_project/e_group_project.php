<?php
if (isset($_POST['f_delete_group_project'])) {
    $f_id_config_project=filter_input(INPUT_POST,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    $lib='DELETE FROM perm_project_group WHERE id_config_project=:f_id_config_project AND id_auth_group=:f_id_auth_group';

    $connSQL=new DB();
    $connSQL->bind('f_id_config_project',$f_id_config_project);
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $connSQL->query($lib);
}

?>
