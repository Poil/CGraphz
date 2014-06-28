<form class="form-horizontal" role="form" name="f_form_dynamic_dashboard" method="post" action="">
<div class="form-group">
    <input type="hidden" name="f_id_config_dynamic_dashboard" id="f_id_config_dynamic_dashboard" value="<?php echo @$cur_dynamic_dashboard->id_config_dynamic_dashboard; ?>" />
    <label class="col-sm-2 control-label" for="f_title"><?php echo TITLE ?></label>
    <div class="col-sm-6">
        <input class="form-control" type="text" name="f_title" id="f_title" value="<?php echo @$cur_dynamic_dashboard->title; ?>" />
    </div>
    <div class="col-sm-offset-2 col-sm-6">
    <input class="btn btn-success" type="submit" name="f_submit_dynamic_dashboard" id="f_submit_dynamic_dashboard" value="<?php echo SUBMIT ?>" />
    </div>
</div>
</form>

<?php
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
?>
    <form class="form-horizontal" role="form" name="f_form_del_dynamic_dashboard" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_dynamic_dashboard'); ?>" onsubmit="return validate_del(this);">
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
        <input type="hidden" name="f_id_config_dynamic_dashboard" id="f_del_id_config_dynamic_dashboard" value="<?php echo $cur_dynamic_dashboard->id_config_dynamic_dashboard; ?>" />
        <input class="btn btn-danger" type="submit" name="f_del_dynamic_dashboard" id="f_del_dynamic_dashboard" value="<?php echo DEL ?>" />
    </div>
    </div>
    </form>
<?php
}
?>
