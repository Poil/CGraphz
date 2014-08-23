<?php
$m_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_module');

$m_form->add('hidden', 'f_id_perm_module')
        ->value(@$cur_module->id_perm_module);

$m_form->add('text', 'f_module')
        ->value(@$cur_module->module)
        ->label(MODULE)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$m_form->add('text', 'f_menu_name')
        ->value(@$cur_module->menu_name)
        ->label(MENU_NAME)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$m_form->add('text', 'f_menu_order')
        ->value(@$cur_module->menu_order)
        ->label(MENU_ORDER)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$m_form->add('text', 'f_component')
        ->value(@$cur_module->component)
        ->autocomplete(false)
        ->label(COMPONENT)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$m_form->add('submit', 'f_submit_module')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $m_form->bindForm();

if (isset($_GET['f_id_perm_module'])) {
   $m_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_perm_module','last_action')).'&amp;last_action=edit_module');
   $m_dform->add('hidden', 'f_id_perm_module')
           ->value($cur_module->id_perm_module);

   $m_dform->add('submit', 'f_del_module')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $m_dform->bindForm();
}
?>
