<?php
if (isset($_POST['f_submit_group_module'])) {
    $f_id_perm_module=filter_input(INPUT_POST,'f_id_perm_module',FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    foreach ($f_id_perm_module as $id_perm_module) {
        $lib='INSERT INTO perm_module_group
                (id_perm_module, id_auth_group)
            VALUES
                (:id_perm_module, :f_id_auth_group)';

        $connSQL=new DB();
        $connSQL->bind('id_perm_module',$id_perm_module);
        $connSQL->bind('f_id_auth_group',$f_id_auth_group);
        $connSQL->query($lib);
    }
}
?>
