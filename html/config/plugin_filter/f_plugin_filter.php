<?php
$m_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_plugin_filter');

$m_form->add('hidden', 'f_id_config_plugin_filter')
        ->value(@$cur_plugin_filter->id_config_plugin_filter);

$m_form->add('text', 'f_plugin_filter_desc')
        ->value(@$cur_plugin_filter->plugin_filter_desc)
        ->label(DESC)
        ->placeholder('text')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('text', 'f_plugin_filter_p')
        ->value(@$cur_plugin_filter->plugin)
        ->label(PLUGIN)
        ->placeholder('regexp')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('text', 'f_plugin_filter_pi')
        ->value(@$cur_plugin_filter->plugin_instance)
        ->label(PLUGIN_INSTANCE)
        ->placeholder('regexp')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('text', 'f_plugin_filter_t')
        ->value(@$cur_plugin_filter->type)
        ->label(TYPE)
        ->placeholder('regexp')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('text', 'f_plugin_filter_ti')
        ->value(@$cur_plugin_filter->type_instance)
        ->label(TYPE_INSTANCE)
        ->placeholder('regexp')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('text', 'f_plugin_filter_plugin_order')
        ->value(@$cur_plugin_filter->plugin_order)
        ->label(DISPLAYED_ORDER)
        ->placeholder('integer')
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$m_form->add('submit', 'f_submit_plugin_filter')
        ->iType('add')
        ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5 col-lg-5')
        ->value(SUBMIT);

echo $m_form->bindForm();

if (isset($_GET['f_id_config_plugin_filter'])) {
   $m_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_plugin_filter','last_action')).'&amp;last_action=edit_plugin_filter');
   $m_dform->add('hidden', 'f_id_config_plugin_filter')
           ->value($cur_plugin_filter->id_config_plugin_filter);

   $m_dform->add('submit', 'f_del_plugin_filter')
           ->iType('delete')
           ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
           ->inputGrid('col-xs-6 col-md-5 col-lg-5"')
           ->value(DEL);
   echo $m_dform->bindForm();
}
?>
