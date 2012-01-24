<form name="f_form_user" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_group'); ?>">
	<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
	<label for="f_group">Groupe</label>
		<input type="text" name="f_group" id="f_group" value="<?php echo @$cur_group->group; ?>" /><br />
	<label for="f_group_description">Description</label>
		<input type="text" name="f_group_description" id="f_group_description" value="<?php echo @$cur_group->group_description; ?>" /><br />
	<input type="submit" name="f_submit_group" id="f_submit_group" value="Envoyer" />
</form>

<?php
if (isset($_GET['f_id_auth_group'])) {
?>
	<form name="f_form_del_group" method="post" action="">
		<input type="hidden" name="f_id_auth_group" id="f_del_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
		<input type="submit" name="f_del_group" id="f_del_group" value="Supprimer" />
	</form>
<?php
}
?>