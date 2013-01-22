<?php
if (isset($_GET['f_id_auth_group'])) {
?>
	<form name="f_form_user_group" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_group'); ?>">
		<input type="hidden" name="f_id_config_dynamic_dashboard" id="f_id_config_dynamic_dashboard" value="<?php echo @$cur_dynamic_dashboard->id_config_dynamic_dashboard; ?>" />
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$f_id_auth_group; ?>" />
		<input readonly="readonly" type="text" name="f_group" id="f_group" value="<?php echo @$cur_dynamic_dashboard_group->group; ?>" />
		<input type="submit" name="f_delete_dynamic_dashboard_group" id="f_delete_dynamic_dashboard_group" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_dynamic_dashboard_group" method="post" action="">
		<input type="hidden" name="f_id_config_dynamic_dashboard" id="f_id_config_dynamic_dashboard" value="<?php echo @$cur_dynamic_dashboard->id_config_dynamic_dashboard; ?>" />
		<label for="f_id_auth_group"><?php echo GROUP ?></label>
		<?php 
		echo '<select name="f_id_auth_group" id="f_id_auth_group">';
			for ($i=0; $i<$cpt_group; $i++) {
				echo '<option value="'.$all_group[$i]->id_auth_group.'">';
					echo $all_group[$i]->group.' ('.$all_group[$i]->group_description.')';
				echo '</option>';
			}
		echo '</select>';		
		?>
		<br />
		<label for="f_group_manager">Manager</label>
		<input type="checkbox" name="f_group_manager" id="f_group_manager" value="manager" />
		<input type="submit" name="f_submit_dynamic_dashboard_group" id="f_submit_dynamic_dashboard_group" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
