<form name="f_form_dynamic_dashboard" method="post" action="">
	<input type="hidden" name="f_id_config_dynamic_dashboard" id="f_id_config_dynamic_dashboard" value="<?php echo @$cur_dynamic_dashboard->id_config_dynamic_dashboard; ?>" />
	<label for="f_title"><?php echo TITLE ?></label>
		<input type="text" name="f_title" id="f_title" value="<?php echo @$cur_dynamic_dashboard->title; ?>" /><br />
	<input type="submit" name="f_submit_dynamic_dashboard" id="f_submit_dynamic_dashboard" value="<?php echo SUBMIT ?>" />
</form>

<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
?>
	<form name="f_form_del_dynamic_dashboard" method="post" action="">
		<input type="hidden" name="f_id_config_dynamic_dashboard" id="f_del_id_config_dynamic_dashboard" value="<?php echo $cur_dynamic_dashboard->id_config_dynamic_dashboard; ?>" />
		<input type="submit" name="f_del_dynamic_dashboard" id="f_del_dynamic_dashboard" value="<?php echo DEL ?>" />
	</form>
<?php
}
?>
