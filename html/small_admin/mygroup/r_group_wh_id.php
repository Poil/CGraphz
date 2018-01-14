<?php
if (isset($_GET['f_id_auth_group'])) {
    $f_id_auth_group=filter_input(INPUT_GET,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT * FROM auth_group WHERE id_auth_group=:f_id_auth_group';
    $connSQL->bind('f_id_auth_group',$f_id_auth_group);
    $cur_group=$connSQL->row($lib);
}
?>
