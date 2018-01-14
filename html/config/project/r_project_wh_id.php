<?php
if (isset($_GET['f_id_config_project'])) {
    $f_id_config_project=filter_input(INPUT_GET,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='SELECT * FROM config_project WHERE id_config_project=:f_id_config_project';
    $connSQL->bind('f_id_config_project',$f_id_config_project);
    $cur_project=$connSQL->row($lib);
}
?>
