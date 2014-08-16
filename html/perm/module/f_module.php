<?php
$m_form = new Form('horizontal', removeqsvar($cur_url, 'f_id_perm_module'));

$m_form->add('hidden', 'f_id_perm_module')
        ->value(@$cur_module->id_perm_module);

$m_form->add('text', 'f_module')
        ->value(@$cur_module->module)
        ->label(MODULE)
        ->labelGrid('col-xs-3 col-md-1')
        ->inputGrid('col-xs-4 col-md-3');

$m_form->add('text', 'f_menu_name')
        ->value(@$cur_module->menu_name)
        ->label(MENU_NAME)
        ->labelGrid('col-xs-3 col-md-1')
        ->inputGrid('col-xs-4 col-md-3');

$m_form->add('text', 'f_menu_order')
        ->value(@$cur_module->menu_order)
        ->label(MENU_ORDER)
        ->labelGrid('col-xs-3 col-md-1')
        ->inputGrid('col-xs-4 col-md-3');

$m_form->add('text', 'f_component')
        ->value(@$cur_module->component)
        ->label(COMPONENT)
        ->labelGrid('col-xs-3 col-md-1')
        ->inputGrid('col-xs-4 col-md-3');

$m_form->add('submit', 'f_submit_module')
        ->iType('add')
        ->labelGrid('col-xs-offset-3 col-md-offset-1')
        ->inputGrid('col-xs-4 col-md-3"')
        ->value(SUBMIT);

echo $m_form->bindForm();

if (isset($_GET['f_id_perm_module'])) {
   $m_dform = new Form('horizontal', removeqsvar($cur_url, 'f_id_perm_module'));
   $m_dform->add('hidden', 'f_id_perm_module')
           ->value($cur_module->id_perm_module);

   $m_dform->add('submit', 'f_del_module')
           ->iType('delete')
           ->labelGrid('col-xs-offset-3 col-md-offset-1')
           ->inputGrid('col-xs-4 col-md-3"')
           ->value(DEL);
   echo $m_dform->bindForm();
}
?>
