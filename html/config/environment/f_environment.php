<form name="f_form_environment" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_environment'); ?>">
	<input type="hidden" name="f_id_config_environment" id="f_id_config_environment" value="<?php echo @$cur_environment->id_config_environment; ?>" />
	<label for="f_environment">Environnement</label>
		<input type="text" name="f_environment" id="f_environment" value="<?php echo @$cur_environment->environment; ?>" /><br />
	<label for="f_environment_description">Description</label>
		<input type="text" name="f_environment_description" id="f_environment_description" value="<?php echo @$cur_environment->environment_description; ?>" /><br />
	<input type="submit" name="f_submit_environment" id="f_submit_environment" value="Envoyer" />
</form>

<?php
if (isset($_GET['f_id_config_environment'])) {
?>
	<form name="f_form_del_environment" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_environment'); ?>">
		<input type="hidden" name="f_id_config_environment" id="f_del_id_config_environment" value="<?php echo $cur_environment->id_config_environment; ?>" />
		<input type="submit" name="f_del_environment" id="f_del_environment" value="Supprimer" />
	</form>
<?php
}
?>