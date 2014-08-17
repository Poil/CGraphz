<?php
$e_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_environment');

$e_form->add('hidden', 'f_id_config_environment')
        ->value(@$cur_environment->id_config_environment);

$e_form->add('text', 'f_environment')
        ->value(@$cur_environment->environment)
        ->label(ENV)
        ->placeholder('text')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$e_form->add('text', 'f_environment_desc')
        ->value(@$cur_environment->environment_description)
        ->label(DESC)
        ->placeholder('text')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$e_form->add('submit', 'f_submit_environment')
        ->iType('add')
        ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5 col-lg-5')
        ->value(SUBMIT);

echo $e_form->bindForm();

if (isset($_GET['f_id_config_environment'])) {
   $m_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_environment','last_action')).'&amp;last_action=edit_environment');
   $m_dform->add('hidden', 'f_id_config_environment')
           ->value($cur_environment->id_config_environment);

   $m_dform->add('submit', 'f_del_environment')
           ->iType('delete')
           ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
           ->inputGrid('col-xs-6 col-md-5 col-lg-5"')
           ->value(DEL);
   echo $m_dform->bindForm();
}
?>
