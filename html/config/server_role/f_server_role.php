<?php
if (isset($_GET['f_id_config_role'])) {
?>
	<form name="f_form_server_role" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_role'); ?>" onsubmit="return validate_del(this);">
		<input type="hidden" name="f_id_config_role" id="f_id_config_role" value="<?php echo $f_id_config_role; ?>" />
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
		<input readonly="readonly" type="text" name="f_role_desc" id="f_role_desc" value="<?php echo $cur_server_role->role_description; ?>" />
		<input type="submit" name="f_delete_server_role" id="f_delete_server_role" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_formserver_role_" method="post" action="">
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
		<label for="f_id_config_role"><?php echo PROJECT ?></label>
		<?php 
		echo '<select name="f_id_config_role" id="f_id_config_role">';
			for ($i=0; $i<$cpt_role; $i++) {
				echo '<option value="'.$all_role[$i]->id_config_role.'">';
					echo $all_role[$i]->role.' ('.$all_role[$i]->role_description.')';
				echo '</option>';
			}
		echo '</select>';
		?>
		<input type="submit" name="f_submit_server_role" id="f_submit_server_role" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
