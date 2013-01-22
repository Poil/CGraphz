<form name="f_form_group_user" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_user'); ?>">
	<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
	<label for="f_id_auth_user"><?php echo USER ?></label>
	<?php 
	if ($cur_group_user->id_auth_user) {
		echo '<input type="text" value="'.$cur_group_user->user.'" readonly="readonly" />';
		echo '<input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="'.$cur_group_user->id_auth_user.'" />';
	} else {
		echo '<select name="f_id_auth_user" id="f_id_auth_user">';
			for ($i=0; $i<$cpt_user; $i++) {
				echo '<option value="'.$all_user[$i]->id_auth_user.'">';
					echo $all_user[$i]->user.' ('.$all_user[$i]->nom.' '.$all_user[$i]->prenom.')';
				echo '</option>';
			}
		echo '</select>';
	}
	?>
	<br />
	<label for="f_manager"><?php echo MANAGER ?></label>
	<?php if ($cur_group_user->manager) { $check=' checked="checked" '; } ?>
	<input type="checkbox" name="f_manager" id="f_manager" value="manager" <?php echo $check; ?>/><br />
	<input type="submit" name="f_submit_group_user" id="f_submit_group_user" value="<?php echo SUBMIT ?>" />
</form>
<?php 
if (isset($_GET['f_id_auth_user'])) {
?>
	<form name="f_form_group_user" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_user'); ?>">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
		<input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="<?php echo @$f_id_auth_user; ?>" />
		<input type="submit" name="f_delete_group_user" id="f_delete_group_user" value="<?php echo DEL ?>" />
	</form>
<?php
}
?>
