<?php
if (isset($_GET['f_id_auth_group'])) {
?>
	<form class="form-horizontal" name="f_form_module_group" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_group'); ?>" onsubmit="return validate_del(this);">
		<div class="form-group">
		<input type="hidden" name="f_id_perm_module" id="f_id_perm_module" value="<?php echo $cur_module->id_perm_module; ?>" />
		<input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $f_id_auth_group; ?>" />
		<input readonly="readonly" type="text" name="f_group" id="f_group" value="<?php echo $cur_module_group->group; ?>" />
		<input class="btn btn-default" type="submit" name="f_delete_module_group" id="f_delete_module_group" value="<?php echo DEL ?>" />
		</div>
	</form>
<?php
} else {
	?> 
	<form class="form-horizontal" name="f_form_module_group" method="post" action="">
		<div class="form-group">
		<input type="hidden" name="f_id_perm_module" id="f_id_perm_module" value="<?php echo $cur_module->id_perm_module; ?>" />
		<label class="col-sm-3 control-label" for="f_id_auth_group"><?php echo GROUP ?></label>
		<div class="col-sm-6">
		<?php 
		echo '<select name="f_id_auth_group" id="f_id_auth_group">';
			for ($i=0; $i<$cpt_group; $i++) {
				echo '<option value="'.$all_group[$i]->id_auth_group.'">';
					echo $all_group[$i]->group.' ('.$all_group[$i]->group_description.')';
				echo '</option>';
			}
		echo '</select>';
		?>
		</div>
		<div class="col-sm-2">
			<input class="btn btn-default" type="submit" name="f_submit_module_group" id="f_submit_module_group" value="<?php echo SUBMIT ?>" />
		</div>
		</div>
	</form>
	<?php 
}
?>
