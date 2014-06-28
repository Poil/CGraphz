<?php
if (isset($_GET['f_id_perm_module'])) {
?>
    <form class="form-inline" role="form" name="f_form_group_module" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_perm_module'); ?>" onsubmit="return validate_del(this);">
        <div class="form-group">
        <input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
        <input type="hidden" name="f_id_perm_module" id="f_id_perm_module" value="<?php echo @$f_id_perm_module; ?>" />
        <label class="sr-only" for="f_module"><?php echo MODULE ?></label>
        <input class="form-control" readonly="readonly" type="text" name="f_module" id="f_module" value="<?php echo $cur_group_module->module; ?>" /><br />
        </div>
        <div class="form-group">
        <label class="sr-only" for="f_component"><?php echo COMPONANT ?></label>
        <input class="form-control" readonly="readonly" type="text" name="f_component" id="f_component" value="<?php echo $cur_group_module->component; ?>" /><br />
        </div>
        <input class="btn btn-danger" type="submit" name="f_delete_group_module" id="f_delete_group_module" value="<?php echo DEL ?>" />
    </form>
<?php
} else {
    ?> 
    <form class="form-inline" role="form" name="f_form_group_module" method="post" action="">
        <div class="form-group">
        <input type="hidden" name="f_id_auth_group" id="f_id_auth_group" value="<?php echo $cur_group->id_auth_group; ?>" />
        <label class="sr-only" for="f_id_perm_module"><?php echo MODULE ?></label>
        <?php 
        echo '<select class="form-control" name="f_id_perm_module" id="f_id_perm_module">';
            for ($i=0; $i<$cpt_module; $i++) {
                echo '<option value="'.$all_module[$i]->id_perm_module.'">';
                    echo $all_module[$i]->module.' - '.$all_module[$i]->component;
                echo '</option>';
            }
        echo '</select>';
        ?>
        </div>
        <input class="btn btn-success" type="submit" name="f_submit_group_module" id="f_submit_group_module" value="<?php echo SUBMIT ?>" />
    </form>
    <?php 
}
?>
