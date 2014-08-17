<?php
$u_form = new Form('horizontal', removeqsvar($cur_url, 'last_action').'&amp;last_action=edit_user');

$u_form->add('hidden', 'f_id_auth_user')
        ->value(@$cur_user->id_auth_user);

$u_form->add('text', 'f_user')
        ->value(@$cur_user->user)
        ->label(USER)
        ->labelGrid('col-xs-4 col-md-2')
        ->inputGrid('col-xs-4 col-md-3');

$u_form->add('select', 'f_type')
        ->value(@$cur_user->type)
        ->label(MENU_NAME)
        ->options(array('mysql','ldap'))
        ->labelGrid('col-xs-4 col-md-2')
        ->inputGrid('col-xs-4 col-md-3');

$u_form->add('text', 'f_passwd')
        ->iType('password')
        ->label(PASSWORD)
        ->labelGrid('col-xs-4 col-md-2')
        ->inputGrid('col-xs-4 col-md-3');

$u_form->add('text', 'f_prenom')
        ->value(@$cur_user->prenom)
        ->label(FIRSTNAME)
        ->labelGrid('col-xs-4 col-md-2')
        ->inputGrid('col-xs-4 col-md-3');

$u_form->add('text', 'f_nom')
        ->value(@$cur_user->nom)
        ->label(NAME)
        ->labelGrid('col-xs-4 col-md-2')
        ->inputGrid('col-xs-4 col-md-3');

$u_form->add('text', 'f_mail')
        ->value(@$cur_user->mail)
        ->label(EMAIL)
        ->labelGrid('col-xs-4 col-md-2')
        ->inputGrid('col-xs-4 col-md-3');

$u_form->add('submit', 'f_submit_user')
        ->iType('add')
        ->labelGrid('col-xs-offset-4 col-md-offset-2')
        ->inputGrid('col-xs-4 col-md-3')
        ->value(SUBMIT);

echo $u_form->bindForm();

if (isset($_GET['f_id_auth_user'])) {
   $u_dform = new Form('horizontal', removeqsvar($cur_url, array('f_id_auth_user','last_action')).'&amp;last_action=edit_user');
   $u_dform->add('hidden', 'f_id_auth_user')
           ->value($cur_user->id_auth_user);

   $u_dform->add('submit', 'f_del_user')
           ->iType('delete')
           ->labelGrid('col-xs-offset-3 col-md-offset-2')
           ->inputGrid('col-xs-4 col-md-3')
           ->value(DEL);
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
