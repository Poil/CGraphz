<?php
if (isset($_GET['f_id_config_project'])) {
   $sp_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_project','last_action')).'&amp;last_action=edit_project');
   $sp_form->fieldset(true);
   $sp_form->legend(DEL);
   $sp_form->add('hidden', 'f_id_config_project')
           ->value($f_id_config_project);

   $sp_form->add('hidden', 'f_id_config_server')
           ->value($cur_server->id_config_server);

   $sp_form->add('text', 'f_project')
           ->readonly(true)
           ->value($cur_server_project->project);

   $sp_form->add('submit', 'f_delete_server_project')
           ->iType('delete')
           ->value(DEL);
} else {
   $sp_form = new Form('inline', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_project');
   $sp_form->fieldset(true);
   $sp_form->legend(ADD);

   $sp_form->add('hidden', 'f_id_config_server')
           ->value($cur_server->id_config_server);

   $sp_form->add('select','f_id_config_project')
            ->options($all_project, 'id_config_project', 'project');

   $sp_form->add('submit', 'f_submit_server_project')
           ->iType('add')
           ->value(SUBMIT);
}
echo $sp_form->bindForm();
?>
