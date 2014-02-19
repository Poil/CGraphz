<?php
if (isset($_GET['f_id_perm_module'])) {
?>
	<form name="f_form_group_module" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_perm_module'); ?>" onsubmit="return validate_del(this);">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
		<input type="hidden" name="f_id_perm_module" id="f_id_perm_module" value="<?php echo @$f_id_perm_module; ?>" />
		<label for="f_module"><?php echo MODULE ?></label>
		<input readonly="readonly" type="text" name="f_module" id="f_module" value="<?php echo $cur_group_module->module; ?>" /><br />
		<label for="f_component"><?php echo COMPONANT ?></label>
		<input readonly="readonly" type="text" name="f_component" id="f_component" value="<?php echo $cur_group_module->component; ?>" /><br />
		<input type="submit" name="f_delete_group_module" id="f_delete_group_module" value="<?php echo DEL ?>" />
	</form>
<?php
} else {
	?> 
	<form name="f_form_group_module" method="post" action="">
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
		<label for="f_id_perm_module"><?php echo MODULE ?></label>
		<?php 
		echo '<select name="f_id_perm_module" id="f_id_perm_module">';
			for ($i=0; $i<$cpt_module; $i++) {
				echo '<option value="'.$all_module[$i]->id_perm_module.'">';
					echo $all_module[$i]->module.' - '.$all_module[$i]->component;
				echo '</option>';
			}
		echo '</select>';
		?>
		<input type="submit" name="f_submit_group_module" id="f_submit_group_module" value="<?php echo SUBMIT ?>" />
	</form>
	<?php 
}
?>
