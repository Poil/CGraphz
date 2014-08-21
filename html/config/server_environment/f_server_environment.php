<?php
if (isset($_GET['f_id_config_environment'])) {
   $sg_form = new Form('inline', removeqsvar($cur_url, array('f_id_config_environment','last_action')).'&amp;last_action=edit_environment');
   $sg_form->fieldset(true);
   $sg_form->legend(DEL);
   $sg_form->add('hidden', 'f_id_config_environment')
           ->value($f_id_config_environment);

   $sg_form->add('hidden', 'f_id_config_server')
           ->value($cur_server->id_config_server);

   $sg_form->add('text', 'f_environment')
           ->readonly(true)
           ->value($cur_server_environment->environment);

   $sg_form->add('submit', 'f_delete_server_environment')
           ->iType('delete')
           ->value(DEL);
} else {
   $sg_form = new Form('inline', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_environment');
   $sg_form->fieldset(true);
   $sg_form->legend(ADD);

   $sg_form->add('hidden', 'f_id_config_server')
           ->value($cur_server->id_config_server);

   $sg_form->add('select','f_id_config_environment')
            ->options($all_environment, 'id_config_environment', 'environment');

   $sg_form->add('submit', 'f_submit_server_environment')
           ->iType('add')
           ->value(SUBMIT);
}
echo $sg_form->bindForm();
?>
