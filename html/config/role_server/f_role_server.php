
<?php
if (isset($_GET['f_id_config_server'])) {
   $rs_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_server','last_action')).'&amp;last_action=edit_server');
   $rs_form->fieldset(true);
   $rs_form->legend(DEL);
   $rs_form->add('hidden', 'f_id_config_server')
           ->value($f_id_config_server);

   $rs_form->add('hidden', 'f_id_config_role')
           ->value($cur_role->id_config_role);

   $rs_form->add('text', 'f_server')
           ->readonly(true)
           ->value($cur_role_server->server_name);

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
           ->label(FILTER_SRV_ALREADY_DEF_ROLE)
           ->onclick("$('#f_submit_role_server').click()")
           ->inputGrid('col-xs-12 col-md-12');

   $rs_form->add('select','f_id_config_server')
            ->options($all_server, 'id_config_server', 'server_name')
            ->inputGrid('col-xs-12 col-md-12')
            ->multiple(true)
            ->fieldClasses('multiselect');

   $rs_form->add('submit', 'f_submit_role_server')
           ->iType('add')
           ->value(SUBMIT)
           ->labelGrid('col-xs-offset-0 col-md-offset-0')
           ->inputGrid('col-xs-12 col-md-12');
}
echo $rs_form->bindForm();
?>
