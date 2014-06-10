<form name="f_form_del_server_check" method="post" action="" onsubmit="return validate_del(this);">
	<select name="f_server_name_to_del[]" id="f_server_name_to_del" class="multiselect" multiple="multiple">
		<?php 
		for ($i=0; $i<$cpt_deleted_server; $i++) {
			echo '<option value="'.$all_deleted_server[$i]->server_name.'">';
				echo $all_deleted_server[$i]->server_name;
			echo '</option>';
		}
		?>
	</select>
	<div class="clearfix"></div><br />

	<input type="submit" name="f_del_server_check" id="f_del_server_check" value="<?php echo DEL ?>" />
</form>

