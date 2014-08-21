			
<?php
if (isset($_GET['f_id_config_server'])) {
   $rs_form = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_server','last_action')).'&amp;last_action=edit_server');
   $rs_form->fieldset(true);
   $rs_form->legend(DEL);
   $rs_form->add('hidden', 'f_id_config_server')
           ->value($f_id_config_server);

   $rs_form->add('hidden', 'f_id_config_role')
           ->value($cur_role->id_config_role);

   $rs_form->add('text', 'f_server')
           ->readonly(true)
           ->value($cur_role_server->server);

   $rs_form->add('submit', 'f_delete_role_server')
           ->iType('delete')
           ->value(DEL);
} else {
   $rs_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_server');
   $rs_form->fieldset(true);
   $rs_form->legend(ADD);

   $rs_form->add('hidden', 'f_id_config_role')
           ->value($cur_role->id_config_role);

   $rs_form->add('checkbox','f_filter_server_in_role')
           ->value('true')
           ->checked($f_filter_server_in_role)
           ->label('filter server')
           ->labelGrid('col-xs-3 col-md-2')
           ->inputGrid('col-xs-4 col-md-3')
           ->onclick("$('#f_submit_role_server').click()");

   $rs_form->add('select','f_id_config_server')
            ->label(SERVER)
            ->labelGrid('col-xs-3 col-md-2')
            ->inputGrid('col-xs-4 col-md-3')
            ->options($all_server, 'id_config_server', 'server_name');

   $rs_form->add('submit', 'f_submit_role_server')
           ->iType('add')
           ->value(SUBMIT);
}
echo $rs_form->bindForm();
?>
