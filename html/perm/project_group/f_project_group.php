<?php
if (isset($_GET['f_id_auth_group'])) {
?>
    <form class="form-inline" role="form" name="f_form_project_group" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_group').'&amp;last_action=edit_group'; ?>" onsubmit="return validate_del(this);">
        <div class="form-group">
        <input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo $cur_project->id_config_project; ?>" />
        <input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $f_id_auth_group; ?>" />
        <input class="form-control" readonly="readonly" type="text" name="f_group" id="f_group" value="<?php echo $cur_project_group->group; ?>" />
        </div>
        <input class="btn btn-danger" type="submit" name="f_delete_project_group" id="f_delete_project_group" value="<?php echo DEL ?>" />
    </form>
<?php
} else {
    ?> 
    <form class="form-inline" role="form" name="f_form_project_group" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_group').'&amp;last_action=edit_group'; ?>">
        <div class="form-group">
        <input type="hidden" name="f_id_config_project" id="f_id_config_project" value="<?php echo $cur_project->id_config_project; ?>" />
        <label class="sr-only" for="f_id_auth_group"><?php echo GROUP ?></label>
        <?php 
        echo '<select class="form-control" name="f_id_auth_group" id="f_id_auth_group">';
            for ($i=0; $i<$cpt_group; $i++) {
                echo '<option value="'.$all_group[$i]->id_auth_group.'">';
                    echo $all_group[$i]->group.' ('.$all_group[$i]->group_description.')';
                echo '</option>';
            }
        echo '</select>';
        ?>
        </div>
        <input class="btn btn-success" type="submit" name="f_submit_project_group" id="f_submit_project_group" value="<?php echo SUBMIT ?>" />
    </form>
    <?php 
}
?>
