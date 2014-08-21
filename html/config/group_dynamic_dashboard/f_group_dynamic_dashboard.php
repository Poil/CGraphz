<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
   $gpm_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_dynamic_dashboard','last_action')).'&amp;last_action=edit_dynamic_dashboard');
   $gpm_form->fieldset(true);
   $gpm_form->legend(DEL);
   $gpm_form->add('hidden', 'f_id_config_dynamic_dashboard')
           ->value($f_id_config_dynamic_dashboard);

   $gpm_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gpm_form->add('text', 'f_title')
           ->readonly(true)
           ->value($cur_group_dynamic_dashboard->title);

   $gpm_form->add('submit', 'f_delete_group_dynamic_dashboard')
           ->iType('delete')
           ->value(DEL);
} else {
   $gpm_form = new Form('inline', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_dynamic_dashboard');
   $gpm_form->fieldset(true);
   $gpm_form->legend(ADD);

   $gpm_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gpm_form->add('select','f_id_config_dynamic_dashboard')
            ->options($all_dynamic_dashboard, 'id_config_dynamic_dashboard', 'title');

   $gpm_form->add('submit', 'f_submit_group_dynamic_dashboard')
           ->iType('add')
           ->value(SUBMIT);
}
echo $gpm_form->bindForm();
?>
