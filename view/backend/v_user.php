<?php
echo '<h1>'.MANAGE_USERS.'</h1>';
include(DIR_FSROOT.'/html/auth/user/w_user.php');
include(DIR_FSROOT.'/html/auth/user_group/e_user_group_wh_id.php');
include(DIR_FSROOT.'/html/auth/user/e_user.php');
include(DIR_FSROOT.'/html/auth/user/r_user_wh_id.php');
include(DIR_FSROOT.'/html/auth/user/r_user.php');
include(DIR_FSROOT.'/html/auth/user/d_user.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_user_group_class='';
$tab_user_class='active';

if (isset($_GET['f_id_auth_user'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_auth_user').'"><button type="button" class="btn btn-primary">'.ADD.' '.USER.'</button></a>';
    if (isset($_GET['f_id_auth_group']) || $last_action=='edit_group') {
        $tab_user_group_class='active';
        $tab_user_class='';
    }
}

if (isset($cur_user)) {
    $user_href='edit';
    $user_title=EDIT.' '.USER;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_user_class.'"><a href="#user_'.$user_href.'" role="tab" data-toggle="tab">'.$user_title.'</a></li>
          <li class="'.$tab_user_group_class.'"><a href="#user_group" role="tab" data-toggle="tab">User Groups</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $user_href='add';
    $user_title=ADD.' '.USER;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#user_'.$user_href.'" role="tab" data-toggle="tab">'.$user_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_user_class.'" id="user_'.$user_href.'"><fieldset>';
if (isset($_GET['f_id_auth_user'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/auth/user/f_user.php');
echo '</fieldset></div>';

if (isset($_GET['f_id_auth_user'])) {
    echo '<div class="tab-pane '.$tab_user_group_class.'" id="user_group"><fieldset>';
    echo '<legend>'.PROJECT_PERMS.'</legend>';
    include(DIR_FSROOT.'/html/auth/user_group/w_user_group.php');
    include(DIR_FSROOT.'/html/auth/user_group/e_user_group.php');
    include(DIR_FSROOT.'/html/auth/user_group/r_user_group_wh_id.php');
    include(DIR_FSROOT.'/html/auth/user_group/r_user_group.php');
    include(DIR_FSROOT.'/html/auth/user_group/d_user_group.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_auth_group'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_auth_group').'&amp;last_action=edit_group"><button type="button" class="btn btn-primary">'.ADD.' '.GROUP.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/auth/user_group/f_user_group.php');
    
    echo '</div>';
}        
echo '</div>';
echo '<div class="clearfix"></div>';
?>
