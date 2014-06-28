<?php
if (isset($_GET['f_id_config_project'])) {
?>
    <form class="form-inline" role="form" name="f_form_group_project" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_project'); ?>" onsubmit="return validate_del(this);">
    <div class="form-group">
        <input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
        <input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo @$f_id_config_project; ?>" />
        <input readonly="readonly" class="form-control" type="text" name="f_project" id="f_project" value="<?php echo $cur_group_project->project; ?>" />
    </div>
    <div class="form-group">
        <input class="btn btn-danger" type="submit" name="f_delete_group_project" id="f_delete_group_project" value="<?php echo DEL ?>" />
    </div>
    </form>
<?php
} else {
    ?> 
    <form class="form-inline" role="form" name="f_form_group_project" method="post" action="">
    <div class="form-group">
        <input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
        <label class="sr-only" for="f_id_config_project"><?php echo PROJECT ?></label>
        <?php 
        echo '<select class="form-control" name="f_id_config_project" id="f_id_config_project">';
            for ($i=0; $i<$cpt_project; $i++) {
                echo '<option value="'.$all_project[$i]->id_config_project.'">';
                    echo $all_project[$i]->project.' ('.$all_project[$i]->project_description.')';
                echo '</option>';
            }
        echo '</select>';
        ?>
    </div>
    <div class="form-group">
        <input class="btn btn-success" type="submit" name="f_submit_group_project" id="f_submit_group_project" value="<?php echo SUBMIT ?>" />
    </div>
    </form>
    <?php 
}
?>
