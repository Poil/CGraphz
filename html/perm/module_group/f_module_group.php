<?php
$mg_form = new Form('inline', removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');
$mg_form->fieldset(true);

if (isset($_GET['f_id_auth_group'])) {
   $mg_form->legend(DEL);
   $mg_form->add('hidden', 'f_id_perm_module')
           ->value($cur_module->id_perm_module);

   $mg_form->add('hidden', 'f_id_auth_group')
           ->value($f_id_auth_group);

   $mg_form->add('text', 'f_group')
           ->readonly(true)
           ->value($cur_module_group->group);

   $mg_form->add('submit', 'f_delete_module_group')
           ->iType('delete')
           ->value(DEL);
} else {
   $mg_form->legend(ADD, removeqsvar($cur_url, array('f_id_auth_group','last_action')).'&amp;last_action=edit_group');

   $mg_form->add('hidden', 'f_id_perm_module')
           ->value($cur_module->id_perm_module);

   $mg_form->add('select','f_id_auth_group')
            ->options($all_group, 'id_auth_group', 'group');

   $mg_form->add('submit', 'f_submit_module_group')
           ->iType('add')
           ->value(SUBMIT);
}
echo $mg_form->bindForm();
?>
