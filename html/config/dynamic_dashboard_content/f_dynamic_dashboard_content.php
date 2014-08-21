<?php
$ddc_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_dynamic_dashboard_content');

$ddc_form->add('hidden', 'f_id_config_dynamic_dashboard_content')
        ->value(@$cur_dynamic_dashboard_content->id_config_dynamic_dashboard_content);

$ddc_form->add('hidden', 'f_id_config_dynamic_dashboard')
        ->value(@$cur_dynamic_dashboard->id_config_dynamic_dashboard);

$ddc_form->add('text', 'f_title')
        ->value(@$cur_dynamic_dashboard_content->title)
        ->label(TITLE)
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$ddc_form->add('text', 'f_dash_ordering')
        ->value(@$cur_dynamic_dashboard_content->dash_ordering)
        ->label(DISPLAYED_ORDER)
        ->autocomplete(false)
        ->labelGrid('col-xs-4 col-md-2 col-lg-2')
        ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$ddc_form->add('text', 'f_regex_srv')
         ->value(@$cur_dynamic_dashboard_content->regex_srv)
         ->label(REGEX_SRV)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid('col-xs-4 col-md-2 col-lg-2')
         ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$ddc_form->add('select','f_preload_filter')
        ->options($all_plugin_filter, 'id_config_plugin_filter', array('plugin','plugin_instance','type','type_instance'))
        ->optionSeparator('-')
        ->enableData(true)
        ->label(PRESAVED_FILTER)
        ->labelGrid('col-xs-3 col-md-2')
        ->inputGrid('col-xs-8 col-md-9');

$ddc_form->add('text', 'f_regex_p_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_p_filter)
         ->label(REGEX_PLUGIN)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid('col-xs-4 col-md-2 col-lg-2')
         ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$ddc_form->add('text', 'f_regex_pi_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_pi_filter)
         ->label(REGEX_PLUGIN_INSTANCE)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid('col-xs-4 col-md-2 col-lg-2')
         ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$ddc_form->add('text', 'f_regex_t_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_t_filter)
         ->label(REGEX_TYPE)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid('col-xs-4 col-md-2 col-lg-2')
         ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$ddc_form->add('text', 'f_regex_ti_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_ti_filter)
         ->label(REGEX_TYPE_INSTANCE)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid('col-xs-4 col-md-2 col-lg-2')
         ->inputGrid('col-xs-6 col-md-5 col-lg-5');

$ddc_form->add('select','f_rrd_ordering')
        ->options(array('S','P','PC','PI','T','TI'))
        ->label(GRAPH_ORDER)
        ->labelGrid('col-xs-3 col-md-2')
        ->inputGrid('col-xs-8 col-md-9');

$ddc_form->add('button', 'f_test_regex')
         ->value(TEST.' regex');

$ddc_form->add('submit', 'f_submit_dynamic_dashboard_content')
         ->iType('add')
         ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
         ->inputGrid('col-xs-6 col-md-5 col-lg-5 col-lg-5')
         ->value(SUBMIT);

echo $ddc_form->bindForm();

if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
   $ddc_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_dynamic_dashboard_content','last_action')).'&amp;last_action=edit_dynamic_dashboard_content');
   $ddc_dform->add('hidden', 'f_id_config_dynamic_dashboard_content')
           ->value($cur_dynamic_dashboard_content->id_config_dynamic_dashboard_content);

   $ddc_dform->add('submit', 'f_del_dynamic_dashboard_content')
           ->iType('delete')
           ->labelGrid('col-xs-offset-4 col-md-offset-2 col-lg-offset-2')
           ->inputGrid('col-xs-6 col-md-5 col-lg-5')
           ->value(DEL);

   echo $ddc_dform->bindForm();
}
?>
	
<div id="displaytest" style="display:none;" title="<?php echo CLICK_TO_CLOSE ?>"></div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#f_test_regex').click(function() {
			$("#displaytest").load('html/config/dynamic_dashboard_content/ajax_dynamic_dashboard_content_test_regex.php',
				{
					'f_regex_srv' : $('#f_regex_srv').val(),
					'f_regex_p' : $('#f_regex_p_filter').val(),
					'f_regex_pi' : $('#f_regex_pi_filter').val(),
					'f_regex_t' : $('#f_regex_t_filter').val(),
					'f_regex_ti' : $('#f_regex_ti_filter').val(),
					'f_rrd_ordering' : $('#f_rrd_ordering').val()
				},
				function() {
					$("#displaytest").show();
				}
			);
			return false;
		});
		$("#displaytest").click(function() {
			$("#displaytest").hide();		
		});
		$("#f_preload_filter").change(function(){
			var p=$("#f_preload_filter option:selected").data('plugin');
			var pi=$("#f_preload_filter option:selected").data('plugin_instance');
			var t=$("#f_preload_filter option:selected").data('type');
			var ti=$("#f_preload_filter option:selected").data('type_instance');

			if (p) { $('#f_regex_p_filter').val(p); }
			else { $('#f_regex_p_filter').val(''); }

			if (pi) { $('#f_regex_pi_filter').val(pi); }
			else { $('#f_regex_pi_filter').val(''); }

			if (t) { $('#f_regex_t_filter').val(t); }
			else { $('#f_regex_t_filter').val(''); }

			if (ti) { $('#f_regex_ti_filter').val(ti); }
			else { $('#f_regex_ti_filter').val(''); }
		});	
	});
</script>
