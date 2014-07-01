<form name="f_form_user" method="post" action="" class="form-horizontal" role="form">
    <input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="<?php echo @$cur_user->id_auth_user; ?>" />
    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_user"><?php echo USER ?></label>
        <div class="col-sm-6">
            <input class="form-control" type="text" name="f_user" id="f_user" value="<?php echo @$cur_user->user; ?>" /> 
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_type"><?php echo TYPE ?></label>
        <div class="col-sm-6">
            <select class="form-control" name="f_type" id="f_type">
                <option value="mysql" <?php if (@$cur_user->type=='mysql') echo ' selected="selected" '; ?>>MySQL</option>
                <option value="ldap" <?php if (@$cur_user->type=='ldap') echo ' selected="selected" '; ?>>LDAP</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_passwd"><?php echo PASSWORD ?></label>
        <div class="col-sm-6">
            <input class="form-control"  type="password" name="f_passwd" id="f_passwd" value="" autocomplete="off" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_prenom"><?php echo FIRSTNAME ?></label>
        <div class="col-sm-6">
            <input class="form-control"  type="text" name="f_prenom" id="f_prenom" value="<?php echo @$cur_user->prenom; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_nom"><?php echo NAME ?></label>
        <div class="col-sm-6">
            <input class="form-control"  type="text" name="f_nom" id="f_nom" value="<?php echo @$cur_user->nom; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label" for="f_mail"><?php echo EMAIL ?></label>
        <div class="col-sm-6">
            <input class="form-control"  type="text" name="f_mail" id="f_mail" value="<?php echo @$cur_user->mail; ?>" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
        <input class="btn btn-success" type="submit" name="f_submit_user" id="f_submit_user" value="<?php echo SUBMIT ?>" />
        </div>
    </div>
</form>

<?php
if (isset($_GET['f_id_auth_user'])) {
?>
    <form class="form-horizontal" role="form" name="f_form_del_user" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_user'); ?>" onsubmit="return validate_del(this);">
        <input type="hidden" name="f_id_auth_user" id="f_del_id_auth_user" value="<?php echo $cur_user->id_auth_user; ?>" />
        <input type="submit" name="f_del_user" id="f_del_user" value="<?php echo DEL ?>" />
    </form>
<?php
}
?>

<script type="text/javascript">
$("#f_type").change(function () {
    if($(this).val()=='ldap') {
        $('#f_passwd').attr('disabled','disabled');
    } else {
        $('#f_passwd').removeAttr('disabled');
    }
})
.change();
</script>
