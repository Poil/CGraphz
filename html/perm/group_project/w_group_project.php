<?php
if (isset($_POST['f_submit_group_project'])) {
    $f_id_config_project=filter_input(INPUT_POST,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT,FILTER_REQUIRE_ARRAY);
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    foreach ($f_id_config_project as $id_config_project) {
        $lib='INSERT INTO perm_project_group
                (id_config_project, id_auth_group )
            VALUES
                (:id_config_project, :f_id_auth_group)';

        $connSQL=new DB();
        $connSQL->bind('id_config_project',$id_config_project);
        $connSQL->bind('f_id_auth_group',$f_id_auth_group);
        $connSQL->query($lib);
    }
}
?>
