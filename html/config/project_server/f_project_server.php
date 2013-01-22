<?php
if (isset($_GET['f_id_config_server'])) {
?>
	<form name="f_form_project_server" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_server'); ?>">
		<input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo $cur_project->id_config_project; ?>" />
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo $f_id_config_server; ?>" />
		<input readonly="readonly" type="text" name="f_server_name" id="f_server_name" value="<?php echo $cur_project_server->server_name; ?>" />
		<input type="submit" name="f_delete_project_server" id="f_delete_project_server" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_project_server" method="post" action="">
		<label style="width:420px" for="f_filter_server_in_project"><?php echo FILTER_SRV_ALREADY_DEF_PROJECT ?></label>
			<input type="checkbox" name="f_filter_server_in_project" id="f_filter_server_in_project" value="true" <?php if ($f_filter_server_in_project=="true") echo ' checked="checked" '; ?> onclick="$('#f_submit_project_server').click();" /><br />
			<input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo $cur_project->id_config_project; ?>" />
		<?php 
		echo '<select name="f_id_config_server[]" id="f_id_config_server"  class="multiselect" multiple="multiple">';
			for ($i=0; $i<$cpt_server; $i++) {
				echo '<option value="'.$all_server[$i]->id_config_server.'">';
					echo $all_server[$i]->server_name.' ('.$all_server[$i]->server_description.')';
				echo '</option>';
			}
		echo '</select>';
		?>
		<input type="submit" name="f_submit_project_server" id="f_submit_project_server" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
