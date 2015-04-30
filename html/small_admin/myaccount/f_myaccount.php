<?php
$u_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_user');
$u_form->fieldset(true);

$u_form->add('hidden', 'f_id_auth_user')
        ->value(@$cur_user->id_auth_user);

$u_form->add('text', 'f_user')
        ->value(@$cur_user->user)
        ->label(USER)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$u_form->add('select', 'f_type')
        ->value(@$cur_user->type)
        ->label(TYPE)
        ->options(array('mysql','ldap'))
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$u_form->add('text', 'f_passwd')
        ->iType('password')
        ->label(PASSWORD)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$u_form->add('text', 'f_prenom')
        ->value(@$cur_user->prenom)
        ->label(FIRSTNAME)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$u_form->add('text', 'f_nom')
        ->value(@$cur_user->nom)
        ->label(NAME)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$u_form->add('text', 'f_mail')
        ->value(@$cur_user->mail)
        ->label(EMAIL)
        ->autocomplete(false)
        ->labelGrid(IL_CSS)
        ->inputGrid(I_CSS);

$u_form->add('submit', 'f_submit_user')
        ->iType('add')
        ->value(SUBMIT)
        ->labelGrid(SL_CSS)
        ->inputGrid(S_CSS);

echo $u_form->bindForm();

if (isset($_GET['f_id_auth_user'])) {
   $u_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_auth_user','last_action')).'&amp;last_action=edit_user');
   $u_dform->add('hidden', 'f_id_auth_user')
           ->value($cur_user->id_auth_user);

   $u_dform->add('submit', 'f_del_user')
           ->iType('delete')
           ->value(DEL)
           ->labelGrid(SL_CSS)
           ->inputGrid(S_CSS);

   echo $u_dform->bindForm();
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
