<?php
$d_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_dynamic_dashboard');

$d_form->add('hidden', 'f_id_config_dynamic_dashboard')
        ->value(@$cur_dynamic_dashboard->id_config_dynamic_dashboard);

$d_form->add('text', 'f_title')
        ->value(@$cur_dynamic_dashboard->title)
        ->label(TITLE)
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$d_form->add('submit', 'f_submit_dynamic_dashboard')
        ->iType('add')
        ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5 col-lg-5')
        ->value(SUBMIT);

echo $d_form->bindForm();

if (isset($_GET['f_id_config_dynamic_dashboard'])) {
   $dd_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_dynamic_dashboard','last_action')).'&amp;last_action=edit_dynamic_dashboard');
   $dd_dform->add('hidden', 'f_id_config_dynamic_dashboard')
           ->value($cur_dynamic_dashboard->id_config_dynamic_dashboard);

   $dd_dform->add('submit', 'f_del_dynamic_dashboard')
           ->iType('delete')
           ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
           ->inputGrid('col-xs-6 col-md-5 col-lg-5')
           ->value(DEL);
   echo $dd_dform->bindForm();
}
?>
