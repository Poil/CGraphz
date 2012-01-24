<h1>CGRAPHZ</h1>
<br />
<img class="img_menu" height="64" width="64" style="float:left" src="img/auth.png" />
<br />
<form name="f_form_auth" method="post" action="">
	<label for="f_user">Identifiant</label>
		<input type="text" name="f_user" id="f_user" value="<?php @$_POST['f_user']?>" /><br />
	<label for="f_passwd">Mot de passe</label>
		<input type="password" name="f_passwd" id="f_passwd" value="" /><br />
	<input type="submit" name="f_submit_auth" id="f_submit_auth" value="Envoyer" />
</form>
