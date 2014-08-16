<?php
$p_form = new Form('horizontal', removeqsvar($cur_url, 'f_id_config_project'));

$p_form->add('hidden', 'f_id_config_project')
        ->value(@$cur_project->id_config_project);

$p_form->add('text', 'f_project')
        ->value(@$cur_project->project)
        ->label(PROJECT)
        ->labelGrid('col-xs-3 col-md-1')
        ->inputGrid('col-xs-4 col-md-3');

$p_form->add('text', 'f_project_description')
        ->value(@$cur_project->project_description)
        ->label(DESC)
        ->labelGrid('col-xs-3 col-md-1')
        ->inputGrid('col-xs-4 col-md-3');

$p_form->add('submit', 'f_submit_project')
        ->iType('add')
        ->labelGrid('col-xs-offset-3 col-md-offset-1')
        ->inputGrid('col-xs-4 col-md-3"')
        ->value(SUBMIT);

echo $p_form->bindForm();

if (isset($_GET['f_id_config_project'])) {
   $p_dform = new Form('horizontal', removeqsvar($cur_url, 'f_id_config_project'));

   $p_dform->add('hidden', 'f_id_config_project')
           ->value($cur_project->id_config_project);

   $p_dform->add('submit', 'f_del_project')
           ->iType('delete')
           ->labelGrid('col-xs-offset-3 col-md-offset-1')
           ->inputGrid('col-xs-4 col-md-3"')
           ->value(DEL);

   echo $p_dform->bindForm();
}
?>
