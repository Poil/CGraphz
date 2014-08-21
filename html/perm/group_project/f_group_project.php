<?php
if (isset($_GET['f_id_config_project'])) {
   $gp_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_project','last_action')).'&amp;last_action=edit_project');
   $gp_form->fieldset(true);
   $gp_form->legend(DEL);
   $gp_form->add('hidden', 'f_id_config_project')
           ->value($f_id_config_project);

   $gp_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gp_form->add('text', 'f_project')
           ->readonly(true)
           ->value($cur_group_project->project);

   $gp_form->add('submit', 'f_delete_group_project')
           ->iType('delete')
           ->value(DEL);
} else {
   $gp_form = new Form('inline', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_project');
   $gp_form->fieldset(true);
   $gp_form->legend(ADD);

   $gp_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gp_form->add('select','f_id_config_project')
            ->options($all_project, 'id_config_project', 'project');

   $gp_form->add('submit', 'f_submit_group_project')
           ->iType('add')
           ->value(SUBMIT);
}
echo $gp_form->bindForm();
?>
