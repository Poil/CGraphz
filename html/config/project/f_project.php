<form name="f_form_project" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_project'); ?>">
	<input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo @$cur_project->id_config_project; ?>" />
	<label for="f_project"><?php echo PROJECT ?></label>
		<input type="text" name="f_project" id="f_project" value="<?php echo @$cur_project->project; ?>" /><br />
	<label for="f_project_description"><?php echo DESC ?></label>
		<input type="text" name="f_project_description" id="f_project_description" value="<?php echo @$cur_project->project_description; ?>" /><br />
	<input type="submit" name="f_submit_project" id="f_submit_project" value="<?php echo SUBMIT ?>" />
</form>

<?php
if (isset($_GET['f_id_config_project'])) {
?>
	<form name="f_form_del_project" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_project'); ?>" onsubmit="return validate_del(this);">
		<input type="hidden" name="f_id_config_project" id="f_del_id_config_project" value="<?php echo $cur_project->id_config_project; ?>" />
		<input type="submit" name="f_del_project" id="f_del_project" value="<?php echo DEL ?>" />
	</form>
<?php
}
?>
