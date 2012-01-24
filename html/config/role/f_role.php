<form name="f_form_role" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_role'); ?>">
	<input type="hidden" name="f_id_config_role" id="f_id_config_role" value="<?php echo @$cur_role->id_config_role; ?>" />
	<label for="f_role">Rôle</label>
		<input type="text" name="f_role" id="f_role" value="<?php echo @$cur_role->role; ?>" /><br />
	<label for="f_role_description">Description</label>
		<input type="text" name="f_role_description" id="f_role_description" value="<?php echo @$cur_role->role_description; ?>" /><br />
	<input type="submit" name="f_submit_role" id="f_submit_role" value="Envoyer" />
</form>

<?php
if (isset($_GET['f_id_config_role'])) {
?>
	<form name="f_form_del_role" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_role'); ?>">
		<input type="hidden" name="f_id_config_role" id="f_del_id_config_role" value="<?php echo $cur_role->id_config_role; ?>" />
		<input type="submit" name="f_del_role" id="f_del_role" value="Supprimer" />
	</form>
<?php
}
?>