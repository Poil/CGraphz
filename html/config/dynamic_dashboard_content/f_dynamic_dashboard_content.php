<fieldset>
<?php
$ddc_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_content');

$ddc_form->add('hidden', 'f_id_config_dynamic_dashboard_content')
        ->value(@$cur_dynamic_dashboard_content->id_config_dynamic_dashboard_content);

$ddc_form->add('hidden', 'f_id_config_dynamic_dashboard')
        ->value(@$cur_dynamic_dashboard->id_config_dynamic_dashboard);

$ddc_form->add('text', 'f_title')
         ->value(@$cur_dynamic_dashboard_content->title)
         ->label(TITLE)
         ->autocomplete(false)
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('text', 'f_dash_ordering')
         ->value(@$cur_dynamic_dashboard_content->dash_ordering)
         ->label(ORDER)
         ->autocomplete(false)
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('text', 'f_regex_srv')
         ->value(@$cur_dynamic_dashboard_content->regex_srv)
         ->label(SERVER)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('select','f_preload_filter')
         ->options($all_plugin_filter, 'id_config_plugin_filter', array('plugin','plugin_instance','type','type_instance'))
         ->optionSeparator('-')
         ->enableData(true)
         ->label(PRESAVED_FILTER)
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('text', 'f_regex_p_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_p_filter)
         ->label(PLUGIN)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('text', 'f_regex_pi_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_pi_filter)
         ->label(PLUGIN_INSTANCE)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('text', 'f_regex_t_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_t_filter)
         ->label(TYPE)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('text', 'f_regex_ti_filter')
         ->value(@$cur_dynamic_dashboard_content->regex_ti_filter)
         ->label(TYPE_INSTANCE)
         ->autocomplete(false)
         ->placeholder('regexp')
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('select','f_rrd_ordering')
         ->value(@$cur_dynamic_dashboard_content->rrd_ordering)
         ->options(array('S','P','PC','PI','T','TI','P-T','P-PI-T'))
         ->label(GRAPH_ORDER)
         ->labelGrid(IL_CSS)
         ->inputGrid(I_CSS);

$ddc_form->add('button', 'f_test_regex')
         ->value(TEST.' regex')
         ->labelGrid(SL_CSS)
         ->inputGrid(S_CSS);

$ddc_form->add('submit', 'f_submit_dynamic_dashboard_content')
         ->iType('add')
         ->value(SUBMIT)
         ->labelGrid(SL_CSS)
         ->inputGrid(S_CSS);

echo $ddc_form->bindForm();

if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
   $ddc_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_config_dynamic_dashboard_content','last_action')).'&amp;last_action=edit_content');

   $ddc_dform->add('hidden', 'f_id_config_dynamic_dashboard_content')
           ->value($cur_dynamic_dashboard_content->id_config_dynamic_dashboard_content);

   $ddc_dform->add('submit', 'f_del_dynamic_dashboard_content')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $ddc_dform->bindForm();
}
?>
</fieldset>
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
