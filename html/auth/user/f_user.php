<form name="f_form_user" method="post" action="" class="form-horizontal" role="form">
    <div class="form-group">
        <input type="hidden" name="f_id_auth_user" id="f_id_auth_user" value="<?php echo @$cur_user->id_auth_user; ?>" />
        <label class="col-sm-2 control-label" for="f_user"><?php echo USER ?></label>
            <div class="col-sm-10">
            <input class="form-control" type="text" name="f_user" id="f_user" value="<?php echo @$cur_user->user; ?>" /> 
            </div>
        <label class="col-sm-2 control-label" for="f_type"><?php echo TYPE ?></label>
            <div class="col-sm-10">
            <select class="form-control" name="f_type" id="f_type">
                <option value="mysql" <?php if (@$cur_user->type=='mysql') echo ' selected="selected" '; ?>>MySQL</option>
                <option value="ldap" <?php if (@$cur_user->type=='ldap') echo ' selected="selected" '; ?>>LDAP</option>
            </select>
            </div>
        <label class="col-sm-2 control-label" for="f_passwd"><?php echo PASSWORD ?></label>
            <div class="col-sm-10">
            <input class="form-control"  type="password" name="f_passwd" id="f_passwd" value="" autocomplete="off" />
            </div>
        <label class="col-sm-2 control-label" for="f_prenom"><?php echo FIRSTNAME ?></label>
            <div class="col-sm-10">
            <input class="form-control"  type="text" name="f_prenom" id="f_prenom" value="<?php echo @$cur_user->prenom; ?>" />
            </div>
        <label class="col-sm-2 control-label" for="f_nom"><?php echo NAME ?></label>
            <div class="col-sm-10">
            <input class="form-control"  type="text" name="f_nom" id="f_nom" value="<?php echo @$cur_user->nom; ?>" />
            </div>
        <label class="col-sm-2 control-label" for="f_mail"><?php echo EMAIL ?></label>
            <div class="col-sm-10">
            <input class="form-control"  type="text" name="f_mail" id="f_mail" value="<?php echo @$cur_user->mail; ?>" />
            </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input class="btn btn-default" type="submit" name="f_submit_user" id="f_submit_user" value="<?php echo SUBMIT ?>" />
        </div>
    </div>
</form>

<?php
if (isset($_GET['f_id_auth_user'])) {
?>
    <form name="f_form_del_user" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_auth_user'); ?>" onsubmit="return validate_del(this);">
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
