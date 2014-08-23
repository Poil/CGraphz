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
           ->checked($f_filter_server_in_project)
           ->onclick("$('#f_submit_project_server').click()")
           ->label(FILTER_SRV_ALREADY_DEF_PROJECT)
           ->inputGrid('col-xs-12 col-md-12');

   $ps_form->add('hidden', 'f_id_config_project')
           ->value($cur_project->id_config_project);

   $ps_form->add('select','f_id_config_server')
           ->multiple(true)
           ->fieldClasses('multiselect')
           ->options($all_server, 'id_config_server', 'server_name')
           ->inputGrid('col-xs-12 col-md-12');

   $ps_form->add('submit', 'f_submit_project_server')
           ->iType('add')
           ->value(SUBMIT)
           ->labelGrid('col-xs-offset-0 col-md-offset-0')
           ->inputGrid('col-xs-12 col-md-12');
}
echo $ps_form->bindForm();
?>
