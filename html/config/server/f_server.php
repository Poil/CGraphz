<form class="form-horizontal" role="form" name="f_form_server" method="post" action="">
<input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo @$cur_server->id_config_server; ?>" />
<div class="form-group">
    <label class="col-sm-4 control-label" for="f_server_name">Server name</label>
    <div class="col-sm-6">
    <?php if (isset($cur_server->id_config_server)) { ?>
        <input id="f_server_name" name="f_server_name" value="<?php echo $cur_server->server_name ?>" readonly="readonly" />
    <?php } else { ?>
            <select name="f_server_name[]" id="f_server_name" class="multiselect" multiple="multiple">
            <?php 
            for ($i=0; $i<$cpt_rrdserver; $i++) {
                echo '<option value="'.$all_rrdserver[$i]->server_name.'">';
                echo $all_rrdserver[$i]->server_name;
                echo '</option>';
            } 
            ?>
            </select>
    <?php } ?>        
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label" for="f_server_description"><?php echo DESC ?></label>
    <div class="col-sm-6">
        <input type="text" name="f_server_description" id="f_server_description" value="<?php echo @$cur_server->server_description; ?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label" for="f_collectd_version"><?php echo COLLECTD_VERSION;?></label>
    <div class="col-sm-6">
        <select name="f_collectd_version" id="f_collectd_version">
        <?php
        if (!empty($cur_server->collectd_version)) {
            $cur_version=$cur_server->collectd_version;
        }
        foreach(unserialize(COLLECTD_VERSIONS) as $collectd_version) {
            echo '<option value="'.$collectd_version.'" '.(($collectd_version == $cur_version)?' selected="selected"':'').'>';
            echo ((!is_null($collectd_version)) ? $collectd_version : DEFAULT_VERSION);
            echo '</option>';
        }
        ?>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-4 col-sm-6">
        <input class="btn btn-success" type="submit" name="f_submit_server" id="f_submit_server" value="<?php echo SUBMIT ?>" />
    </div>
</div>
</form>

<?php if (isset($_GET['f_id_config_server'])) { ?>
    <form class="form-horizontal" role="form" name="f_form_del_server" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_server'); ?>" onsubmit="return validate_del(this);">
    <div class="form-group">
        <input type="hidden" name="f_id_config_server" id="f_del_id_config_server" value="<?php echo $cur_server->id_config_server; ?>" />
        <div class="col-sm-offset-4 col-sm-6">
            <input class="btn btn-danger" type="submit" name="f_del_server" id="f_del_server" value="<?php echo DEL ?>" />
        </div>
    </div>
    </form>
<?php } ?>
