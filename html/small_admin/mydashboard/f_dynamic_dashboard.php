<?php
$d_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_dynamic_dashboard');

$d_form->add('hidden', 'f_id_config_dynamic_dashboard')
        ->value(@$cur_dynamic_dashboard->id_config_dynamic_dashboard);

$d_form->add('text', 'f_title')
        ->value(@$cur_dynamic_dashboard->title)
        ->label(TITLE)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$d_form->add('submit', 'f_submit_dynamic_dashboard')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $d_form->bindForm();

if (isset($_GET['f_id_config_dynamic_dashboard'])) {
   $dd_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_dynamic_dashboard','last_action')).'&amp;last_action=edit_dynamic_dashboard');
   $dd_dform->add('hidden', 'f_id_config_dynamic_dashboard')
           ->value($cur_dynamic_dashboard->id_config_dynamic_dashboard);

   $dd_dform->add('submit', 'f_del_dynamic_dashboard')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $dd_dform->bindForm();
}
?>
