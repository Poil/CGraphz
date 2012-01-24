<form name="f_form_user" method="post" action="">
	<input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="<?php echo @$cur_user->id_auth_user; ?>" />
	<label for="f_user">Identifiant</label>
		<input type="text" name="f_user" id="f_user" value="<?php echo @$cur_user->user; ?>" /><br />
	<label for="f_type">Type</label>
		<select name="f_type" id="f_type">
			<option value="mysql" <?php if (@$cur_user->type=='mysql') echo ' selected="selected" '; ?>>MySQL</option>
			<option value="ldap" <?php if (@$cur_user->type=='ldap') echo ' selected="selected" '; ?>>LDAP</option>
		</select><br />
	<label for="f_passwd">Mot de passe</label>
		<input type="password" name="f_passwd" id="f_passwd" value="<?php echo @$cur_user->passwd; ?>" /><br />
	<label for="f_prenom">Prénom</label>
		<input type="text" name="f_prenom" id="f_prenom" value="<?php echo @$cur_user->prenom; ?>" /><br />
	<label for="f_nom">Nom</label>
		<input type="text" name="f_nom" id="f_nom" value="<?php echo @$cur_user->nom; ?>" /><br />
	<label for="f_mail">Email</label>
		<input type="text" name="f_mail" id="f_mail" value="<?php echo @$cur_user->mail; ?>" /><br />
	<input type="submit" name="f_submit_user" id="f_submit_user" value="Envoyer" />
</form>
<script type="text/javascript">
$("#f_type").change(function () {
	if($(this).val()=='ldap') {
		$('#f_passwd').attr('disabled','disabled');
	} else {
		$('#f_passwd').removeAttr('disabled');
	}
})
.change();
</script>