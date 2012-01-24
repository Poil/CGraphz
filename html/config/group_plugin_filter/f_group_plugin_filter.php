<?php
if (isset($_GET['f_id_config_plugin_filter'])) {
?>
	<form name="f_form_group_plugin_filter" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_plugin_filter'); ?>">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
		<input type="hidden" name="f_id_config_plugin_filter" id="f_id_config_plugin_filter" value="<?php echo @$f_id_config_plugin_filter; ?>" />
		<input readonly="readonly" type="text" name="f_plugin_filter_desc" id="f_plugin_filter_desc" value="<?php echo @$cur_plugin_filter_group->plugin_filter_desc; ?>" />
		<input type="submit" name="f_delete_group_plugin_filter" id="f_delete_group_plugin_filter" value="Supprimer" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_group_plugin_filter" method="post" action="">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo @$cur_group->id_auth_group; ?>" />
		<label for="f_id_config_plugin_filter">Utilisateur</label>
		<?php 
		echo '<select name="f_id_config_plugin_filter" id="f_id_config_plugin_filter">';
			for ($i=0; $i<$cpt_plugin_filter; $i++) {
				echo '<option value="'.$all_plugin_filter[$i]->id_config_plugin_filter.'">';
					echo $all_plugin_filter[$i]->plugin_filter_desc;
				echo '</option>';
			}
		echo '</select>';
		?>
		<br />
		<input type="submit" name="f_submit_group_plugin_filter" id="f_submit_group_plugin_filter" value="Envoyer" />
	</form>
	<?php 
}
?>