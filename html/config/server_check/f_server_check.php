<form name="f_form_del_server_check" method="post" action="">
	<select name="f_server_name_to_del[]" id="f_server_name_to_del" class="multiselect" multiple="multiple">
		<?php 
		for ($i=0; $i<$cpt_deleted_server; $i++) {
			echo '<option value="'.$all_deleted_server[$i]->server_name.'">';
				echo $all_deleted_server[$i]->server_name;
			echo '</option>';
		}
		?>
	</select><br />

	<input type="submit" name="f_del_server_check" id="f_del_server_check" value="Supprimer" />
</form>


<script type="text/javascript">
$(function(){
	$.localise('ui.multiselect', {language: 'fr',  path: 'lib/multiselect/locale/'});

	$(".multiselect").multiselect();

});
</script>