<form class="form-horizontal" role="form" name="f_form_module" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_perm_module'); ?>">
    <input type="hidden" name="f_id_perm_module" id="f_id_perm_module" value="<?php echo @$cur_module->id_perm_module; ?>" />
    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_module"><?php echo MODULE ?></label>
        <div class="col-sm-6">
            <input class="form-control" type="text" name="f_module" id="f_module" value="<?php echo @$cur_module->module; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_component"><?php echo COMPONANT ?></label>
        <div class="col-sm-6">
            <input class="form-control" type="text" name="f_component" id="f_component" value="<?php echo @$cur_module->component; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_menu_name"><?php echo MENU_NAME ?></label>
        <div class="col-sm-6">
            <input class="form-control" type="text" name="f_menu_name" id="f_menu_name" value="<?php echo @$cur_module->menu_name; ?>" />
        </div>
    </div>
    <div class="form-group">
    <label class="col-sm-3 control-label" for="f_menu_order"><?php echo MENU_ORDER ?></label>
        <div class="col-sm-6">
            <input class="form-control" type="text" name="f_menu_order" id="f_menu_order" value="<?php echo @$cur_module->menu_order; ?>" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <input class="btn btn-success" type="submit" name="f_submit_module" id="f_submit_module" value="<?php echo SUBMIT ?>" />
        </div>
    </div>
</form>

<?php
if (isset($_GET['f_id_perm_module'])) {
?>
    <form class="form-horizontal" name="f_form_del_module" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_perm_module'); ?>" onsubmit="return validate_del(this);" role="form">
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <input type="hidden" name="f_id_perm_module" id="f_del_id_perm_module" value="<?php echo $cur_module->id_perm_module; ?>" />
            <input class="btn btn-danger" type="submit" name="f_del_module" id="f_del_module" value="<?php echo DEL ?>" />
        </div>
    </div>
    </form>
<?php
}
?>
