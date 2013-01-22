<?php
if (isset($_GET['f_id_auth_group'])) {
?>
	<form name="f_form_user_group" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_group'); ?>">
		<input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="<?php echo @$cur_user->id_auth_user; ?>" />
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$f_id_auth_group; ?>" />
		<input readonly="readonly" type="text" name="f_group" id="f_group" value="<?php echo @$cur_user_group->group; ?>" />
		<input type="submit" name="f_delete_user_group" id="f_delete_user_group" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_user_group" method="post" action="">
		<input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="<?php echo @$cur_user->id_auth_user; ?>" />
		<label for="f_id_auth_group"><?php echo GROUP ?></label>
		<?php 
		echo '<select name="f_id_auth_group" id="f_id_auth_group">';
			for ($i=0; $i<$cpt_group; $i++) {
				echo '<option value="'.$all_group[$i]->id_auth_group.'">';
					echo $all_group[$i]->group.' ('.$all_group[$i]->group_description.')';
				echo '</option>';
			}
		echo '</select>';		
		?>
		<br />
		<label for="f_manager"><?php echo MANAGER ?></label>
		<input type="checkbox" name="f_manager" id="f_manager" value="manager" />
		<input type="submit" name="f_submit_user_group" id="f_submit_user_group" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
