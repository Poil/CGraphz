<form name="f_form_user" method="post" action="">
	<input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="<?php echo @$cur_user->id_auth_user; ?>" />
	<label for="f_user"><?php echo USER ?></label>
		<input type="text" name="f_user" id="f_user" autocomplete="off" /><br />
	<label for="f_type"><?php echo TYPE ?></label>
		<select name="f_type" id="f_type">
			<option value="mysql" <?php if (@$cur_user->type=='mysql') echo ' selected="selected" '; ?>>MySQL</option>
			<option value="ldap" <?php if (@$cur_user->type=='ldap') echo ' selected="selected" '; ?>>LDAP</option>
		</select><br />
	<label for="f_passwd"><?php echo PASSWORD ?></label>
		<input type="password" name="f_passwd" id="f_passwd" autocomplete="off" /><br />
	<label for="f_prenom"><?php echo FIRSTNAME ?></label>
		<input type="text" name="f_prenom" id="f_prenom" autocomplete="off" /><br />
	<label for="f_nom"><?php echo NAME ?></label>
		<input type="text" name="f_nom" id="f_nom" autocomplete="off" /><br />
	<label for="f_mail"><?php echo EMAIL ?></label>
		<input type="text" name="f_mail" id="f_mail" autocomplete="off" /><br />
	<input type="submit" name="f_submit_user" id="f_submit_user" value="<?php echo SUBMIT ?>" />
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
