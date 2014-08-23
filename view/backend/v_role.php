<?php
echo '<h1>'.MANAGE_MODULES.'</h1>';
include(DIR_FSROOT.'/html/config/role/w_role.php');
include(DIR_FSROOT.'/html/config/role_server/e_role_server_wh_id.php');
include(DIR_FSROOT.'/html/config/role/e_role.php');
include(DIR_FSROOT.'/html/config/role/r_role_wh_id.php');
include(DIR_FSROOT.'/html/config/role/r_role.php');
include(DIR_FSROOT.'/html/config/role/d_role.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_role_class='active';
$tab_role_server_class='';

if (isset($_GET['f_id_config_role'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_config_role').'"><button type="button" class="btn btn-primary">'.ADD.' '.ROLE.'</button></a>';
    if (isset($_GET['f_id_config_server']) || $last_action=='edit_server') {
        $tab_role_server_class='active';
        $tab_role_class='';
    } 
}

if (isset($cur_role)) {
    $role_href='edit';
    $role_title=EDIT.' '.ROLE;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_role_class.'"><a href="#role_'.$role_href.'" role="tab" data-toggle="tab">'.$role_title.'</a></li>
          <li class="'.$tab_role_server_class.'" ><a href="#role_server" role="tab" data-toggle="tab">'.SERVER.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $role_href='add';
    $role_title=ADD.' '.ROLE;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#role_'.$role_href.'" role="tab" data-toggle="tab">'.$role_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_role_class.'" id="role_'.$role_href.'"><fieldset>';
echo '<legend>'.ROLE.'</legend>';
echo '<fieldset>';
if (isset($_GET['f_id_config_role'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/config/role/f_role.php');
echo '</fieldset>';
echo '</fieldset></div>';

if (isset($_GET['f_id_config_role'])) {
    echo '<div class="tab-pane '.$tab_role_server_class.'" id="role_server"><fieldset>';
    echo '<legend>'.SERVER.'</legend>';
    include(DIR_FSROOT.'/html/config/role_server/w_role_server.php');
    include(DIR_FSROOT.'/html/config/role_server/e_role_server.php');
    include(DIR_FSROOT.'/html/config/role_server/r_role_server_wh_id.php');
    include(DIR_FSROOT.'/html/config/role_server/r_role_server.php');
    include(DIR_FSROOT.'/html/config/role_server/d_role_server.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_server'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_server').'&amp;last_action=edit_server"><button type="button" class="btn btn-primary">'.ADD.' '.SERVER.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/role_server/f_role_server.php');
    echo '</div>';
}        
echo '</div>';
echo '<div class="clearfix"></div>';
?>
