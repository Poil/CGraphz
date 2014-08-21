<?php
if (isset($_GET['f_id_config_role'])) {
   $sr_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_role','last_action')).'&amp;last_action=edit_role');
   $sr_form->fieldset(true);
   $sr_form->legend(DEL);
   $sr_form->add('hidden', 'f_id_config_role')
           ->value($f_id_config_role);

   $sr_form->add('hidden', 'f_id_config_server')
           ->value($cur_server->id_config_server);

   $sr_form->add('text', 'f_role')
           ->readonly(true)
           ->value($cur_server_role->role);

   $sr_form->add('submit', 'f_delete_server_role')
           ->iType('delete')
           ->value(DEL);
} else {
   $sr_form = new Form('inline', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_role');
   $sr_form->fieldset(true);
   $sr_form->legend(ADD);

   $sr_form->add('hidden', 'f_id_config_server')
           ->value($cur_server->id_config_server);

   $sr_form->add('select','f_id_config_role')
            ->options($all_role, 'id_config_role', 'role');

   $sr_form->add('submit', 'f_submit_server_role')
           ->iType('add')
           ->value(SUBMIT);
}
echo $sr_form->bindForm();
?>
