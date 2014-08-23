<?php
if (isset($_GET['f_id_auth_user'])) {
   /* Edit */
   $gu_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_user');
   
   $gu_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gu_form->add('hidden', 'f_id_auth_user')
           ->value($f_id_auth_user);
   
   $gu_form->add('text','f_user')
           ->value($cur_group_user->user)
           ->readonly(true)
           ->label(USER)
           ->autocomplete(false)
           ->labelGrid(IL_CSS)
           ->inputGrid(I_CSS);
   
   $gu_form->add('checkbox','f_manager')
           ->value('manager')
           ->label(MANAGER)
           ->checked(@$cur_group_user->manager)
           ->inputGrid(C_CSS);
   
   $gu_form->add('submit', 'f_submit_group_user')
           ->iType('add')
           ->value(SUBMIT)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);
   
   echo $gu_form->bindForm();

   /* Delete */
   $gud_form = new Form('horizontal', removeqsvar($cur_url, array('f_id_auth_user','last_action')).'&amp;last_action=edit_user');

   $gud_form->add('hidden', 'f_id_auth_user')
           ->value($cur_group_user->id_auth_user);

   $gud_form->add('hidden', 'f_id_auth_group')
           ->value($f_id_auth_group);

   $gud_form->add('submit', 'f_delete_group_user')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $gud_form->bindForm();
} else {
   /* Add */
   $gu_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_user');
   
   $gu_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);
   
   $gu_form->add('select','f_id_auth_user')
           ->options($all_user, 'id_auth_user', 'user')
           ->label(USER)
           ->labelGrid(IL_CSS)
           ->inputGrid(I_CSS);
   
   $gu_form->add('checkbox','f_manager')
           ->value('manager')
           ->label(MANAGER)
           ->inputGrid(C_CSS);
   
   $gu_form->add('submit', 'f_submit_group_user')
           ->iType('add')
           ->value(SUBMIT)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);
   
   echo $gu_form->bindForm();

}
?>
