<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
?>
	<form name="f_form_group_dynamic_dashboard" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_dynamic_dashboard'); ?>" onsubmit="return validate_del(this);">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
		<input type="hidden" name="f_id_config_dynamic_dashboard" id="f_id_config_dynamic_dashboard" value="<?php echo @$f_id_config_dynamic_dashboard; ?>" />
		<input readonly="readonly" type="text" name="f_title" id="f_title" value="<?php echo @$cur_dynamic_dashboard_group->title; ?>" />
		<input type="submit" name="f_delete_group_dynamic_dashboard" id="f_delete_group_dynamic_dashboard" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_group_dynamic_dashboard" method="post" action="">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
		<label for="f_id_config_dynamic_dashboard"><?php echo DASHBOARD ?></label>
		<?php 
		echo '<select name="f_id_config_dynamic_dashboard" id="f_id_config_dynamic_dashboard">';
			for ($i=0; $i<$cpt_dynamic_dashboard; $i++) {
				echo '<option value="'.$all_dynamic_dashboard[$i]->id_config_dynamic_dashboard.'">';
					echo $all_dynamic_dashboard[$i]->title;
				echo '</option>';
			}
		echo '</select>';
		?>
		<br />
		<input type="submit" name="f_submit_group_dynamic_dashboard" id="f_submit_group_dynamic_dashboard" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
