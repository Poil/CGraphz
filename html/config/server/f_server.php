<form name="f_form_server" method="post" action="">
	<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo @$cur_server->id_config_server; ?>" />
		<?php 
		if (isset($cur_server->id_config_server)) {
			echo '<label for="f_server_name">Server name</label>';
			echo '<input id="f_server_name" name="f_server_name" value="'.$cur_server->server_name.'" readonly="readonly"><br />';
		} else {
		?>
		<select name="f_server_name[]" id="f_server_name" class="multiselect" multiple="multiple">
			<?php 
			for ($i=0; $i<$cpt_rrdserver; $i++) {
				echo '<option value="'.$all_rrdserver[$i]->server_name.'">';
					echo $all_rrdserver[$i]->server_name;
				echo '</option>';
			}
			?>
		</select><br />
		<?php } ?>		
	<label for="f_server_description">Description</label>
		<input type="text" name="f_server_description" id="f_server_description" value="<?php echo @$cur_server->server_description; ?>" /><br />
	<input type="submit" name="f_submit_server" id="f_submit_server" value="Envoyer" />
</form>
<?php
if (isset($_GET['f_id_config_server'])) {
?>
	<form name="f_form_del_server" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_server'); ?>">
		<input type="hidden" name="f_id_config_server" id="f_del_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
		<input type="submit" name="f_del_server" id="f_del_server" value="Supprimer" />
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