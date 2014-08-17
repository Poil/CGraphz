<?php
if (isset($_GET['f_id_config_server'])) {
   $ps_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_server','last_action')).'&amp;last_action=edit_server');
   $ps_form->fieldset(true);

   $ps_form->legend(DEL);
   $ps_form->add('hidden', 'f_id_config_project')
           ->value($cur_project->id_config_project);

   $ps_form->add('hidden', 'f_id_config_server')
           ->value($f_id_config_server);

   $ps_form->add('text', 'f_server_name')
           ->readonly(true)
           ->value($cur_project_server->server_name);

   $ps_form->add('submit', 'f_delete_project_server')
           ->iType('delete')
           ->value(DEL);
} else {
   $ps_form = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_server','last_action')).'&amp;last_action=edit_server');
   $ps_form->fieldset(true);

   $ps_form->legend(ADD);
   $ps_form->add('checkbox','f_filter_server_in_project')
           ->value('true')
           ->label('filter server')
           ->inputGrid('col-sm-offset-2 col-md-9')
           ->checked($f_filter_server_in_project)
           ->onclick("$('#f_submit_project_server').click()");

   $ps_form->add('hidden', 'f_id_config_project')
           ->value($cur_project->id_config_project);

   $ps_form->add('select','f_id_config_server')
            ->label(SERVER)
            ->labelGrid('col-xs-2 col-md-2')
            ->inputGrid('col-xs-9 col-md-9')
            ->multiple(true)
            ->fieldClasses('multiselect')
            ->options($all_server, 'id_config_server', 'server_name');

   $ps_form->add('submit', 'f_submit_project_server')
           ->iType('add')
           ->value(SUBMIT);
}
echo $ps_form->bindForm();
?>
