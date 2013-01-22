<form name="f_form_module" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_perm_module'); ?>">
	<input type="hidden" name="f_id_perm_module" id="f_id_perm_module" value="<?php echo @$cur_module->id_perm_module; ?>" />
	<label for="f_module">Module</label>
		<input type="text" name="f_module" id="f_module" value="<?php echo @$cur_module->module; ?>" /><br />
	<label for="f_component">Composant</label>
		<input type="text" name="f_component" id="f_component" value="<?php echo @$cur_module->component; ?>" /><br />
	<label for="f_menu_name">Nom Menu</label>
		<input type="text" name="f_menu_name" id="f_menu_name" value="<?php echo @$cur_module->menu_name; ?>" /><br />
	<label for="f_menu_order">Ordre Menu</label>
		<input type="text" name="f_menu_order" id="f_menu_order" value="<?php echo @$cur_module->menu_order; ?>" /><br />
	<input type="submit" name="f_submit_module" id="f_submit_module" value="Envoyer" />
</form>

<?php
if (isset($_GET['f_id_perm_module'])) {
?>
	<form name="f_form_del_module" method="post" action="">
		<input type="hidden" name="f_id_perm_module" id="f_del_id_perm_module" value="<?php echo $cur_module->id_perm_module; ?>" />
		<input type="submit" name="f_del_module" id="f_del_module" value="Supprimer" />
	</form>
<?php
}
?>