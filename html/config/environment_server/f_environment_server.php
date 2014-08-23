<?php
if (isset($_GET['f_id_config_server'])) {
   $es_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_server','last_action')).'&amp;last_action=edit_server');
   $es_form->fieldset(true);
   $es_form->legend(DEL);
   $es_form->add('hidden', 'f_id_config_server')
           ->value($f_id_config_server);

   $es_form->add('hidden', 'f_id_config_environment')
           ->value($cur_environment->id_config_environment);

   $es_form->add('text', 'f_server_name')
           ->readonly(true)
           ->value($cur_environment_server->server_name);

   $es_form->add('submit', 'f_delete_environment_server')
           ->iType('delete')
           ->value(DEL);
} else {
   $es_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_server');
   $es_form->fieldset(true);
   $es_form->legend(ADD);

   $es_form->add('hidden', 'f_id_config_environment')
           ->value($cur_environment->id_config_environment);

   $es_form->add('checkbox','f_filter_server_in_environment')
           ->value('true')
           ->label(FILTER_SRV_ALREADY_DEF_ENV)
           ->checked($f_filter_server_in_environment)
           ->onclick("$('#f_submit_environment_server').click()")
           ->inputGrid('col-xs-12 col-md-12');

   $es_form->add('select','f_id_config_server')
           ->multiple(true)
           ->fieldClasses('multiselect')
           ->options($all_server, 'id_config_server', 'server_name')
           ->inputGrid('col-xs-12 col-md-12');

   $es_form->add('submit', 'f_submit_environment_server')
           ->iType('add')
           ->value(SUBMIT)
           ->labelGrid('col-xs-offset-0 col-md-offset-0')
           ->inputGrid('col-xs-12 col-md-12');
}
echo $es_form->bindForm();
?>
