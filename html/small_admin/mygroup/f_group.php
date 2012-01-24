<?php
$perm_grp = new PERMS();
if (($cur_group->id_auth_group && $perm_grp->auth_user_group($_SESSION['S_ID_USER'],$f_id_auth_group,true)) || !$cur_group->id_auth_group) {
?>
<form name="f_form_user" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_group'); ?>">
	<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
	<label for="f_group">Groupe</label>
		<input type="text" name="f_group" id="f_group" value="<?php echo @$cur_group->group; ?>" /><br />
	<label for="f_group_description">Description</label>
		<input type="text" name="f_group_description" id="f_group_description" value="<?php echo @$cur_group->group_description; ?>" /><br />
	<input type="submit" name="f_submit_group" id="f_submit_group" value="Envoyer" />
</form>
<?php
}
?>