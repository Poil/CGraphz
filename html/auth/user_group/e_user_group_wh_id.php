<?php
if (isset($_POST['f_del_user'])) {
    $f_id_auth_user=filter_input(INPUT_POST,'f_id_auth_user',FILTER_SANITIZE_NUMBER_INT);

    $lib='DELETE FROM auth_user_group WHERE id_auth_user=:f_id_auth_user';

    $connSQL=new DB();
    $connSQL->bind('f_id_auth_user',$f_id_auth_user);
    $connSQL->query($lib);
}

?>

