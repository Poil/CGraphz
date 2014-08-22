<?php
if (isset($_GET['f_id_perm_module'])) {
   $gpm_form = new Form('inline', removeqsvar($cur_url, array('f_id_perm_module','last_action')).'&amp;last_action=edit_module');
   $gpm_form->fieldset(true);
   $gpm_form->legend(DEL);
   $gpm_form->add('hidden', 'f_id_perm_module')
           ->value($f_id_perm_module);

   $gpm_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gpm_form->add('text', 'f_module')
           ->readonly(true)
           ->value($cur_group_module->module);

   $gpm_form->add('text', 'f_component')
           ->readonly(true)
           ->value($cur_group_module->component);

   $gpm_form->add('submit', 'f_delete_group_module')
           ->iType('delete')
           ->value(DEL);
} else {
   $gpm_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_module');
   $gpm_form->fieldset(true);
   $gpm_form->legend(ADD);

   $gpm_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gpm_form->add('select','f_id_perm_module')
            ->inputGrid('col-xs-12 col-md-12')
            ->options($all_module, 'id_perm_module', array('module','component'))
            ->multiple(true)
            ->fieldClasses('multiselect');

   $gpm_form->add('submit', 'f_submit_group_module')
           ->iType('add')
           ->value(SUBMIT);
}
echo $gpm_form->bindForm();
?>
