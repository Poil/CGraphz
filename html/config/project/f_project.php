<?php
$p_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_project');

$p_form->add('hidden', 'f_id_config_project')
        ->value(@$cur_project->id_config_project);

$p_form->add('text', 'f_project')
        ->value(@$cur_project->project)
        ->label(PROJECT)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$p_form->add('text', 'f_project_description')
        ->value(@$cur_project->project_description)
        ->label(DESC)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$p_form->add('submit', 'f_submit_project')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $p_form->bindForm();

if (isset($_GET['f_id_config_project'])) {
   $p_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_project','last_action')).'&amp;last_action=edit_project');

   $p_dform->add('hidden', 'f_id_config_project')
           ->value($cur_project->id_config_project);

   $p_dform->add('submit', 'f_del_project')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $p_dform->bindForm();
}
?>
