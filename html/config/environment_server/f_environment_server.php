<?php
if (isset($_GET['f_id_config_server'])) {
?>
	<form name="f_form_environment_server" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_server'); ?>">
		<input type="hidden" name="f_id_config_environment" id="f_id_config_environment" value="<?php echo @$cur_environment->id_config_environment; ?>" />
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo @$f_id_config_server; ?>" />
		<input readonly="readonly" type="text" name="f_server_name" id="f_server_name" value="<?php echo @$cur_environment_server->server_name; ?>" />
		<input type="submit" name="f_delete_environment_server" id="f_delete_environment_server" value="Supprimer" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_environment_server" method="post" action="">
		<label style="width:350px" for="f_filter_server_in_environment">Filtrer les serveurs qui sont déjà définis dans un rôle</label>
			<input type="checkbox" name="f_filter_server_in_environment" id="f_filter_server_in_environment" value="true" <?php if ($f_filter_server_in_environment=="true") echo ' checked="checked" '; ?> onclick="$('#f_submit_environment_server').click();" /><br />
			
		<input type="hidden" name="f_id_config_environment" id="f_id_config_environment" value="<?php echo @$cur_environment->id_config_environment; ?>" />
		<?php 
		echo '<select name="f_id_config_server[]" id="f_id_config_server" class="multiselect" multiple="multiple">';
			for ($i=0; $i<$cpt_server; $i++) {
				echo '<option value="'.$all_server[$i]->id_config_server.'">';
					echo $all_server[$i]->server_name.' ('.$all_server[$i]->server_description.')';
				echo '</option>';
			}
		echo '</select>';
		?>
		<br />
		<input type="submit" name="f_submit_environment_server" id="f_submit_environment_server" value="Envoyer" />
	</form>
	<?php 
}
?>

<script type="text/javascript">
$(function(){
	$.localise('ui.multiselect', {language: 'fr',  path: 'lib/multiselect/locale/'});

	// local
	$(".multiselect").multiselect();
	// remote
	//$("#languages").multiselect({
	//	remoteUrl: "ajax.php"
	//});

});
</script>

