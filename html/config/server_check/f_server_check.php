<?php
$sc_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=clean_server');
$sc_form->fieldset(true);

$sc_form->add('select','f_server_name_to_del')
       ->multiple(true)
       ->fieldClasses('multiselect')
       ->options($all_deleted_server, 'server_name', 'server_name')
       ->inputGrid('col-xs-12 col-md-12');

$sc_form->add('submit', 'f_del_server_check')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid('col-xs-offset-0 col-md-offset-0')
        ->inputGrid('col-xs-12 col-md-12');

echo $sc_form->bindForm();
