<?php
$sc_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=clean_server');

$sc_form->add('select','f_server_name_to_del')
       ->label(SERVER)
       ->labelGrid('col-xs-3 col-md-1')
       ->inputGrid('col-xs-4 col-md-3')
       ->multiple(true)
       ->fieldClasses('multiselect')
       ->options($all_deleted_server, 'server_name', 'server_name');

$sc_form->add('submit', 'f_del_server_check')
        ->iType('add')
        ->labelGrid('col-xs-offset-3 col-md-offset-1')
        ->inputGrid('col-xs-4 col-md-3"')
        ->value(SUBMIT);

echo $sc_form->bindForm();
