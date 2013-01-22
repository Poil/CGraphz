<?php
if (isset($_GET['f_id_config_project'])) {
?>
	<form name="f_form_server_project" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_project'); ?>">
		<input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo $f_id_config_project; ?>" />
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
		<input readonly="readonly" type="text" name="f_project_desc" id="f_project_desc" value="<?php echo $cur_server_project->project_description; ?>" />
		<input type="submit" name="f_delete_server_project" id="f_delete_server_project" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_formserver_project_" method="post" action="">
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
		<label for="f_id_config_project"><?php echo PROJECT ?></label>
		<?php 
		echo '<select name="f_id_config_project" id="f_id_config_project">';
			for ($i=0; $i<$cpt_project; $i++) {
				echo '<option value="'.$all_project[$i]->id_config_project.'">';
					echo $all_project[$i]->project.' ('.$all_project[$i]->project_description.')';
				echo '</option>';
			}
		echo '</select>';
		?>
		<input type="submit" name="f_submit_server_project" id="f_submit_server_project" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
