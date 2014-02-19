<?php
if (isset($_GET['f_id_config_environment'])) {
?>
	<form name="f_form_server_environment" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_environment'); ?>" onsubmit="return validate_del(this);">
		<input type="hidden" name="f_id_config_environment" id="f_id_config_environment" value="<?php echo $f_id_config_environment; ?>" />
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
		<input readonly="readonly" type="text" name="f_environment_desc" id="f_environment_desc" value="<?php echo $cur_server_environment->environment_description; ?>" />
		<input type="submit" name="f_delete_server_environment" id="f_delete_server_environment" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_formserver_environment_" method="post" action="">
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
		<label for="f_id_config_environment"><?php echo PROJECT ?></label>
		<?php 
		echo '<select name="f_id_config_environment" id="f_id_config_environment">';
			for ($i=0; $i<$cpt_environment; $i++) {
				echo '<option value="'.$all_environment[$i]->id_config_environment.'">';
					echo $all_environment[$i]->environment.' ('.$all_environment[$i]->environment_description.')';
				echo '</option>';
			}
		echo '</select>';
		?>
		<input type="submit" name="f_submit_server_environment" id="f_submit_server_environment" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
