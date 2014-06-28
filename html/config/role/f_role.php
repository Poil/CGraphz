<form class="form-horizontal" role="form" name="f_form_role" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_role'); ?>">
    <div class="form-group">
    <input type="hidden" name="f_id_config_role" id="f_id_config_role" value="<?php echo @$cur_role->id_config_role; ?>" />
    <label class="col-sm-2 control-label" for="f_role"><?php echo ROLE ?></label>
        <div class="col-sm-6">
        <input class="form-control" type="text" name="f_role" id="f_role" value="<?php echo @$cur_role->role; ?>" />
        </div>
    </div>
    <div class="form-group">
    <label class="col-sm-2 control-label" for="f_role_description"><?php echo DESC ?></label>
        <div class="col-sm-6">
        <input class="form-control" type="text" name="f_role_description" id="f_role_description" value="<?php echo @$cur_role->role_description; ?>" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input class="btn btn-success" type="submit" name="f_submit_role" id="f_submit_role" value="<?php echo SUBMIT ?>" />
        </div>
    </div>
</form>

<?php
if (isset($_GET['f_id_config_role'])) {
?>
    <form class="form-horizontal" role="form" name="f_form_del_role" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_role'); ?>" onsubmit="return validate_del(this);">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" name="f_id_config_role" id="f_del_id_config_role" value="<?php echo $cur_role->id_config_role; ?>" />
        <input class="btn btn-danger" type="submit" name="f_del_role" id="f_del_role" value="<?php echo DEL ?>" />
        </div>
    </div>
    </form>
<?php
}
?>
