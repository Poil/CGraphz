<?php
$s_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_server');

$s_form->add('hidden', 'f_id_config_server')
        ->value(@$cur_server->id_config_server);

if (isset($cur_server->id_config_server)) {
   $s_form->add('text', 'f_server_name')
           ->value(@$cur_server->server_name)
           ->label(SERVER)
           ->autocomplete(false)
           ->labelGrid(IL_CSS)
           ->inputGrid(I_CSS);
} else {
   $s_form->add('select','f_server_name')
           ->multiple(true)
           ->fieldClasses('multiselect')
           ->options($all_rrdserver, 'server_name', 'server_name')
           ->inputGrid('col-xs-12 col-md-12');
}
$s_form->add('text', 'f_server_description')
       ->value(@$cur_server->server_description)
       ->label(DESC)
       ->autocomplete(false)
       ->labelGrid(IL_CSS)
       ->inputGrid(I_CSS);

$s_form->add('select','f_collectd_version')
       ->label(COLLECTD_VERSION)
       ->options(unserialize(COLLECTD_VERSIONS))
       ->value(@$cur_server->collectd_version)
       ->labelGrid(IL_CSS)
       ->inputGrid(I_CSS);

$s_form->add('submit', 'f_submit_server')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $s_form->bindForm();

if (isset($_GET['f_id_config_server'])) {
   $s_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_server','last_action')).'&amp;last_action=edit_server');

   $s_dform->add('hidden', 'f_id_config_server')
           ->value($cur_server->id_config_server);

   $s_dform->add('submit', 'f_del_server')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $s_dform->bindForm();
}
?>
