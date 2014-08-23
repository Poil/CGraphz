<?php
$m_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_role');

$m_form->add('hidden', 'f_id_config_role')
        ->value(@$cur_role->id_config_role);

$m_form->add('text', 'f_role')
        ->value(@$cur_role->role)
        ->label(ROLE)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$m_form->add('text', 'f_role_desc')
        ->value(@$cur_role->role_description)
        ->label(DESC)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$m_form->add('submit', 'f_submit_role')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $m_form->bindForm();

if (isset($_GET['f_id_config_role'])) {
   $m_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_role','last_action')).'&amp;last_action=edit_role');
   $m_dform->add('hidden', 'f_id_config_role')
           ->value($cur_role->id_config_role);

   $m_dform->add('submit', 'f_del_role')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $m_dform->bindForm();
}
?>
