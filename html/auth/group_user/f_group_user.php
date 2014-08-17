<?php
$gu_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_user');

$gu_form->add('hidden', 'f_id_auth_group')
        ->value(@$cur_group->id_auth_group);

$gu_form->add('select','f_id_auth_user')
        ->options($all_user, 'id_auth_user', 'user')
        ->label(USER)
        ->labelGrid('col-xs-3 col-md-3')
        ->inputGrid('col-xs-9 col-md-9');

$gu_form->add('checkbox','f_manager')
        ->value('manager')
        ->label(MANAGER)
        ->inputGrid('col-sm-offset-3 col-md-9')
        ->checked(@$cur_group_user->manager);

$gu_form->add('submit', 'f_submit_group_user')
        ->iType('add')
        ->labelGrid('col-xs-offset-3 col-md-offset-3')
        ->inputGrid('col-xs-9 col-md-9')
        ->value(SUBMIT);

echo $gu_form->bindForm();

if (isset($_GET['f_id_auth_user'])) {
   $gud_form = new Form('horizontal', removeqsvar($cur_url, array('f_id_auth_user','last_action')).'&amp;last_action=edit_user');

   $gud_form->add('hidden', 'f_id_auth_user')
           ->value($cur_user->id_auth_user);

   $gud_form->add('hidden', 'f_id_auth_group')
           ->value($f_id_auth_group);

   $gud_form->add('submit', 'f_delete_group_user')
           ->iType('delete')
           ->labelGrid('col-xs-offset-3 col-md-offset-3')
           ->inputGrid('col-xs-9 col-md-8')
           ->value(DEL);

   echo $gud_form->bindForm();
}
?>
