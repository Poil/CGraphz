<form class="form-horizontal" role="form" name="f_form_plugin_filter" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_plugin_filter'); ?>">
    <div class="form-group">
    <input type="hidden" name="f_id_config_plugin_filter" id="f_id_config_plugin_filter" value="<?php echo @$cur_plugin_filter->id_config_plugin_filter; ?>" />
    <label class="col-sm-4 control-label" for="f_plugin_filter_desc"><?php echo DESC ?></label>
    <div class="col-sm-6">
    <input class="form-control" type="text" name="f_plugin_filter_desc" id="f_plugin_filter_desc" value="<?php echo @$cur_plugin_filter->plugin_filter_desc; ?>" placeholder="text" />
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-4 control-label" for="f_plugin_filter_p"><?php echo PLUGIN ?></label>
    <div class="col-sm-6">
    <input class="form-control" type="text" name="f_plugin_filter_p" id="f_plugin_filter_p" value="<?php echo @$cur_plugin_filter->plugin; ?>" placeholder="regexp" />
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-4 control-label" for="f_plugin_filter_pi"><?php echo PLUGIN_INSTANCE ?></label>
    <div class="col-sm-6">
    <input class="form-control" type="text" name="f_plugin_filter_pi" id="f_plugin_filter_pi" value="<?php echo @$cur_plugin_filter->plugin_instance; ?>" placeholder="regexp" />
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-4 control-label" for="f_plugin_filter_t"><?php echo TYPE ?></label>
    <div class="col-sm-6">
    <input class="form-control" type="text" name="f_plugin_filter_t" id="f_plugin_filter_t" value="<?php echo @$cur_plugin_filter->type; ?>" placeholder="regexp" />
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-4 control-label" for="f_plugin_filter_ti"><?php echo TYPE_INSTANCE ?></label>
    <div class="col-sm-6">
    <input class="form-control" type="text" name="f_plugin_filter_ti" id="f_plugin_filter_ti" value="<?php echo @$cur_plugin_filter->type_instance; ?>" placeholder="regexp" />
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-4 control-label" for="f_plugin_filter_plugin_order"><?php echo DISPLAYED_ORDER ?></label>
    <div class="col-sm-6">
    <input class="form-control" type="text" name="f_plugin_filter_plugin_order" id="f_plugin_filter_plugin_order" value="<?php echo @$cur_plugin_filter->plugin_order; ?>" placeholder="1" />
    </div>
    </div>

    <div class="form-group">
    <div class="col-sm-offset-4 col-sm-6">
    <input class="btn btn-success" type="submit" name="f_submit_plugin_filter" id="f_submit_plugin_filter" value="<?php echo SUBMIT ?>" />
    </div>
    </div>
</form>


<form class="form-horizontal" role="form" name="f_form_del_plugin_filter" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_plugin_filter'); ?>" onsubmit="return validate_del(this);">
    <div class="form-group form-group-lg">
    <input type="hidden" name="f_id_config_plugin_filter" id="f_del_id_config_plugin_filter" value="<?php echo $cur_plugin_filter->id_config_plugin_filter; ?>" />
    <div class="col-sm-offset-4 col-sm-5">
    <input class="btn btn-danger" type="submit" name="f_del_plugin_filter" id="f_del_plugin_filter" value="<?php echo DEL ?>" />
    </div>
    </div>
</form>
