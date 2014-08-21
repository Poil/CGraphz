<?php
$m_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_role');

$m_form->add('hidden', 'f_id_config_role')
        ->value(@$cur_role->id_config_role);

$m_form->add('text', 'f_role')
        ->value(@$cur_role->role)
        ->label(ROLE)
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('text', 'f_role_desc')
        ->value(@$cur_role->role_description)
        ->label(DESC)
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('submit', 'f_submit_role')
        ->iType('add')
        ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5 col-lg-5')
        ->value(SUBMIT);

echo $m_form->bindForm();

if (isset($_GET['f_id_config_role'])) {
   $m_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_role','last_action')).'&amp;last_action=edit_role');
   $m_dform->add('hidden', 'f_id_config_role')
           ->value($cur_role->id_config_role);

   $m_dform->add('submit', 'f_del_role')
           ->iType('delete')
           ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
           ->inputGrid('col-xs-6 col-md-5 col-lg-5')
           ->value(DEL);
   echo $m_dform->bindForm();
}
?>
