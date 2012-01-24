<?php
if (isset($_GET['f_id_config_server'])) {
?>
	<form name="f_form_role_server" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_server'); ?>">
		<input type="hidden" name="f_id_config_role" id="f_id_config_role" value="<?php echo @$cur_role->id_config_role; ?>" />
		<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo @$f_id_config_server; ?>" />
		<input readonly="readonly" type="text" name="f_server_name" id="f_server_name" value="<?php echo @$cur_role_server->server_name; ?>" />
		<input type="submit" name="f_delete_role_server" id="f_delete_role_server" value="Supprimer" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_role_server" method="post" action="">
		<label style="width:350px" for="f_filter_server_in_role">Filtrer les serveurs qui sont déjà définis dans un rôle</label>
			<input type="checkbox" name="f_filter_server_in_role" id="f_filter_server_in_role" value="true" <?php if ($f_filter_server_in_role=="true") echo ' checked="checked" '; ?> onclick="$('#f_submit_role_server').click();" /><br />
			
		<input type="hidden" name="f_id_config_role" id="f_id_config_role" value="<?php echo @$cur_role->id_config_role; ?>" />
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
		<input type="submit" name="f_submit_role_server" id="f_submit_role_server" value="Envoyer" />
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

