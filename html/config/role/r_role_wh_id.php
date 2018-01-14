<?php
if (isset($_GET['f_id_config_role'])) {
    $f_id_config_role=filter_input(INPUT_GET,'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT * FROM config_role WHERE id_config_role=:f_id_config_role';
    $connSQL->bind('f_id_config_role',$f_id_config_role);
    $cur_role=$connSQL->row($lib);
}
?>
