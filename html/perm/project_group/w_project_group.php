<?php
if (isset($_POST['f_submit_project_group'])) {
    $f_id_config_project=filter_input(INPUT_POST,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);

    if (!empty($f_id_auth_group)) {
        foreach ($f_id_auth_group as $id_auth_group) {
            $lib='INSERT INTO perm_project_group
                    (id_config_project, id_auth_group)
                VALUES
                    (:f_id_config_project, :id_auth_group)';

            $connSQL=new DB();
            $connSQL->bind('f_id_config_project',$f_id_config_project);
            $connSQL->bind('id_auth_group',$id_auth_group);
            $connSQL->query($lib);
        }
    }
}
?>
