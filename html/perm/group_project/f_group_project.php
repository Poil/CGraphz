<?php
if (isset($_GET['f_id_config_project'])) {
?>
	<form name="f_form_group_project" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_project'); ?>">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
		<input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo @$f_id_config_project; ?>" />
		<input readonly="readonly" type="text" name="f_project" id="f_project" value="<?php echo $cur_group_project->project; ?>" />
		<input type="submit" name="f_delete_group_project" id="f_delete_group_project" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_group_project" method="post" action="">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
		<label for="f_id_config_project"><?php echo PROJECT ?></label>
		<?php 
		echo '<select name="f_id_config_project" id="f_id_config_project">';
			for ($i=0; $i<$cpt_project; $i++) {
				echo '<option value="'.$all_project[$i]->id_config_project.'">';
					echo $all_project[$i]->project.' ('.$all_project[$i]->project_description.')';
				echo '</option>';
			}
		echo '</select>';
		?>
		<input type="submit" name="f_submit_group_project" id="f_submit_group_project" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
