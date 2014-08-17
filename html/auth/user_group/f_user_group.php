<?php
if (isset($_GET['f_id_auth_group'])) {
   $ug_form = new Form('inline', removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');
   $ug_form->fieldset(true);

   $ug_form->legend(DEL);
   $ug_form->add('hidden', 'f_id_auth_user')
           ->value($cur_user->id_auth_user);

   $ug_form->add('hidden', 'f_id_auth_group')
           ->value($f_id_auth_group);

   $ug_form->add('text', 'f_group')
           ->readonly(true)
           ->value($cur_user_group->group);

   $ug_form->add('submit', 'f_delete_user_group')
           ->iType('delete')
           ->value(DEL);
} else {
   $ug_form = new Form('horizontal', removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');
   $ug_form->fieldset(true);

   $ug_form->legend(ADD, removeqsvar($cur_url, 'f_id_auth_group').'&amp;last_action=edit_group');

   $ug_form->add('hidden', 'f_id_auth_user')
           ->value($cur_user->id_auth_user);

   $ug_form->add('select','f_id_auth_group')
           ->options($all_group, 'id_auth_group', 'group')
           ->label(GROUP)
           ->labelGrid('col-xs-3 col-md-2')
           ->inputGrid('col-xs-4 col-md-3');

   $ug_form->add('checkbox','f_manager')
           ->value('manager')
           ->label(MANAGER)
           ->inputGrid('col-sm-offset-2 col-md-3')
           ->checked($f_manager);

   $ug_form->add('submit', 'f_submit_user_group')
           ->iType('add')
           ->value(SUBMIT);
}
echo $ug_form->bindForm();
?>
