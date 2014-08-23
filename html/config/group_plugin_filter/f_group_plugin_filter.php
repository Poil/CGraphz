<?php
if (isset($_GET['f_id_config_plugin_filter'])) {
   $gpf_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_plugin_filter','last_action')).'&amp;last_action=edit_plugin_filter');
   $gpf_form->fieldset(true);
   $gpf_form->legend(DEL);
   $gpf_form->add('hidden', 'f_id_config_plugin_filter')
           ->value($f_id_config_plugin_filter);

   $gpf_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gpf_form->add('text', 'f_project')
           ->readonly(true)
           ->value($cur_group_plugin_filter->plugin_filter_desc);

   $gpf_form->add('submit', 'f_delete_group_plugin_filter')
           ->iType('delete')
           ->value(DEL);
} else {
   $gpf_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_plugin_filter');
   $gpf_form->fieldset(true);
   $gpf_form->legend(ADD);

   $gpf_form->add('hidden', 'f_id_auth_group')
           ->value($cur_group->id_auth_group);

   $gpf_form->add('select','f_id_config_plugin_filter')
            ->options($all_plugin_filter, 'id_config_plugin_filter', 'plugin_filter_desc')
            ->inputGrid('col-xs-12 col-md-12')
            ->multiple(true)
            ->fieldClasses('multiselect');

   $gpf_form->add('submit', 'f_submit_group_plugin_filter')
           ->iType('add')
           ->labelGrid('col-xs-offset-0 col-md-offset-0')
           ->inputGrid('col-xs-12 col-md-12')
           ->value(SUBMIT);
}
echo $gpf_form->bindForm();
?>
