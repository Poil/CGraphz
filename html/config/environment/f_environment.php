<?php
$e_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_environment');

$e_form->add('hidden', 'f_id_config_environment')
        ->value(@$cur_environment->id_config_environment);

$e_form->add('text', 'f_environment')
        ->value(@$cur_environment->environment)
        ->label(ENV)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$e_form->add('text', 'f_environment_description')
        ->value(@$cur_environment->environment_description)
        ->label(DESC)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$e_form->add('submit', 'f_submit_environment')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $e_form->bindForm();

if (isset($_GET['f_id_config_environment'])) {
   $m_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_environment','last_action')).'&amp;last_action=edit_environment');
   $m_dform->add('hidden', 'f_id_config_environment')
           ->value($cur_environment->id_config_environment);

   $m_dform->add('submit', 'f_del_environment')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $m_dform->bindForm();
}
?>
