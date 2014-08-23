<?php
$g_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_group');

$g_form->add('hidden', 'f_id_auth_group')
        ->value(@$cur_group->id_auth_group);

$g_form->add('text', 'f_group')
        ->value(@$cur_group->group)
        ->label(GROUP)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$g_form->add('text', 'f_group_description')
        ->value(@$cur_group->group_description)
        ->label(DESC)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$g_form->add('submit', 'f_submit_group')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $g_form->bindForm();

if (isset($_GET['f_id_auth_group'])) {
   $g_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');
   $g_dform->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $g_dform->add('submit', 'f_del_group')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $g_dform->bindForm();
}
?>
