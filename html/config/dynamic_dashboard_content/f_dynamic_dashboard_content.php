<form name="f_form_dynamic_dashboard_content" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_dynamic_dashboard_content'); ?>">
	<input type="hidden" name="f_id_config_dynamic_dashboard_content" id="f_id_config_dynamic_dashboard_content" value="<?php echo @$cur_dynamic_dashboard_content->id_config_dynamic_dashboard_content; ?>" />
	<input type="hidden" name="f_id_config_dynamic_dashboard" id="f_id_config_dynamic_dashboard" value="<?php echo $_GET['f_id_config_dynamic_dashboard'] ?>" />
	<label for="f_title"><?php echo TITLE ?></label>
		<input type="text" name="f_title" id="f_title" value="<?php echo @$cur_dynamic_dashboard_content->title; ?>" /><br />
		
	<label for="f_ordering"><?php echo DISPLAYED_ORDER ?></label>
		<input type="text" name="f_dash_ordering" id="f_dash_ordering" value="<?php echo @$cur_dynamic_dashboard_content->dash_ordering; ?>" /><br />
		
	<label for="f_regex_srv"><?php echo REGEX_SRV ?></label>
		<input type="text" name="f_regex_srv" id="f_regex_srv" value="<?php echo @$cur_dynamic_dashboard_content->regex_srv; ?>" /><br />
	
	<br />
	<label for="f_preload_filter"><?php echo PRESAVED_FILTER?></label>
	<?php 
		echo '<select name="f_preload_filter" id="f_preload_filter">';
			echo '<option />';
			for ($i=0; $i<$cpt_plugin_filter; $i++) {
				$str=$all_plugin_filter[$i]->plugin;
				$str.=($all_plugin_filter[$i]->plugin_instance != '') ? '-'.$all_plugin_filter[$i]->plugin_instance:'';
				$str.='/'.$all_plugin_filter[$i]->type;
				$str.=($all_plugin_filter[$i]->type_instance != '')?'-'.$all_plugin_filter[$i]->type_instance:'';
				echo '<option value="'.$str.'">';
					$str='('.$all_plugin_filter[$i]->plugin.')';
					$str.=($all_plugin_filter[$i]->plugin_instance != '') ? '-('.$all_plugin_filter[$i]->plugin_instance.')':'';
					$str.='/('.$all_plugin_filter[$i]->type.')';
					$str.=($all_plugin_filter[$i]->type_instance != '')?'-('.$all_plugin_filter[$i]->type_instance.')':'';
					echo $str;
				echo '</option>';
			}
		echo '</select><br />';
		?>
	
	<label for="f_regex_p_filter"><?php echo REGEX_PLUGIN ?></label>
		<input type="text" name="f_regex_p_filter" id="f_regex_p_filter" value="<?php echo @$cur_dynamic_dashboard_content->regex_p_filter; ?>" /><br />
	<label for="f_regex_pi_filter"><?php echo REGEX_PLUGIN_INSTANCE ?></label>
		<input type="text" name="f_regex_pi_filter" id="f_regex_pi_filter" value="<?php echo @$cur_dynamic_dashboard_content->regex_pi_filter; ?>" /><br />		
	<label for="f_regex_t_filter"><?php echo REGEX_TYPE ?></label>
		<input type="text" name="f_regex_t_filter" id="f_regex_t_filter" value="<?php echo @$cur_dynamic_dashboard_content->regex_t_filter; ?>" /><br />	
	<label for="f_regex_ti_filter"><?php echo REGEX_TYPE_INSTANCE ?></label>
		<input type="text" name="f_regex_ti_filter" id="f_regex_ti_filter" value="<?php echo @$cur_dynamic_dashboard_content->regex_ti_filter; ?>" /><br />	
	<label for="f_rrd_ordering"><?php echo GRAPH_ORDER ?></label>
		<select name="f_rrd_ordering" id="f_rrd_ordering">
			<option value="S" <?php echo (@$cur_dynamic_dashboard_content->rrd_ordering=='S')?'selected="selected"':''; ?>><?php echo SERVER ?></option>
			<option value="P" <?php echo (@$cur_dynamic_dashboard_content->rrd_ordering=='P')?'selected="selected"':''; ?>><?php echo PLUGIN ?></option>
			<option value="PC" <?php echo (@$cur_dynamic_dashboard_content->rrd_ordering=='PC')?'selected="selected"':''; ?>><?php echo PLUGIN_CATEGORY ?></option>
			<option value="PI" <?php echo (@$cur_dynamic_dashboard_content->rrd_ordering=='PI')?'selected="selected"':''; ?>><?php echo PLUGIN_INSTANCE ?></option>
			<option value="T" <?php echo (@$cur_dynamic_dashboard_content->rrd_ordering=='T')?'selected="selected"':''; ?>><?php echo TYPE ?></option>
			<option value="TI" <?php echo (@$cur_dynamic_dashboard_content->rrd_ordering=='TI')?'selected="selected"':''; ?>><?php echo TYPE_INSTANCE ?></option>
		</select>
		<br />
	
	<input type="button" value="<?php echo TEST ?>" id="f_test_regex" /><br />
	<input type="submit" name="f_submit_dynamic_dashboard_content" id="f_submit_dynamic_dashboard_content" value="<?php echo SUBMIT ?>" />
</form>

<?php
if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
?>
	<form name="f_form_del_dynamic_dashboard_content" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_dynamic_dashboard_content'); ?>" onsubmit="return validate_del(this);">
		<input type="hidden" name="f_id_config_dynamic_dashboard_content" id="f_del_id_config_dynamic_dashboard_content" value="<?php echo $cur_dynamic_dashboard_content->id_config_dynamic_dashboard_content; ?>" />
		<input type="submit" name="f_del_dynamic_dashboard_content" id="f_del_dynamic_dashboard_content" value="<?php echo DEL ?>" />
	</form>
<?php
}
?>

<div id="displaytest" style="display:none;" title="<?php echo CLICK_TO_CLOSE ?>">
	
</div>

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
		});
		$("#displaytest").click(function() {
			$("#displaytest").hide();		
		});
		$("#f_preload_filter").change(function(){
			var str=$("#f_preload_filter").val().split('/');
			var pstr=str[0].split('-');
			var tstr=str[1].split('-');
			if (pstr[0]) {
				$('#f_regex_p_filter').val(pstr[0]);
			} else {
				$('#f_regex_p_filter').val('');
			}
			if (pstr[1]) {
				$('#f_regex_pi_filter').val(pstr[1]);
			} else {
				$('#f_regex_pi_filter').val('');
			}
			if (tstr[0]) {
				$('#f_regex_t_filter').val(tstr[0]);
			} else {
				$('#f_regex_t_filter').val('');
			}
			if (tstr[1]) {
				$('#f_regex_ti_filter').val(tstr[1]);
			} else {
				$('#f_regex_ti_filter').val('');
			}
		});	
	});
</script>
