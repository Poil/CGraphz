<?php
if (isset($_GET['f_id_auth_group'])) {
   $pg_form = new Form('inline', removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');
   $pg_form->fieldset(true);

   $pg_form->legend(DEL);
   $pg_form->add('hidden', 'f_id_config_project')
           ->value($cur_project->id_config_project);

   $pg_form->add('hidden', 'f_id_auth_group')
           ->value($f_id_auth_group);

   $pg_form->add('text', 'f_group')
           ->readonly(true)
           ->value($cur_project_group->group);

   $pg_form->add('submit', 'f_delete_project_group')
           ->iType('delete')
           ->value(DEL);
} else {
   $pg_form = new Form('horizontal', removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');
   $pg_form->fieldset(true);

   $pg_form->legend(ADD, removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');

   $pg_form->add('hidden', 'f_id_config_project')
           ->value($cur_project->id_config_project);

   $pg_form->add('select','f_id_auth_group')
           ->options($all_group, 'id_auth_group', 'group')
           ->multiple(true)
           ->fieldClasses('multiselect')
           ->inputGrid('col-xs-12 col-md-12');


   $pg_form->add('submit', 'f_submit_project_group')
           ->iType('add')
           ->value(SUBMIT)
           ->labelGrid('col-xs-offset-0 col-md-offset-0')
           ->inputGrid('col-xs-12 col-md-12');

}
echo $pg_form->bindForm();
?>
