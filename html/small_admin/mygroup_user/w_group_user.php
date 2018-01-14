<?php
if (isset($_POST['f_submit_group_user'])) {
    $f_id_auth_user=filter_input(INPUT_POST,'f_id_auth_user',FILTER_SANITIZE_NUMBER_INT);
    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    if(isset($_POST['f_manager'])!="") {
        $f_manager='1';
    } else {
        $f_manager='0';
    }

    $lib='REPLACE INTO auth_user_group (id_auth_user,id_auth_group,manager)
        VALUES (:f_id_auth_user, :f_id_auth_group, :f_manager)';

    $connSQL=new DB();
    $connSQL->bind('f_id_auth_user',$f_id_auth_user);
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $connSQL->query($lib);
}
?>
