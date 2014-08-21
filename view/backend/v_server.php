<?php
echo '<h1>'.MANAGE_SERVERS.'</h1>';
// Module server_check delete post before read.
include(DIR_FSROOT.'/html/config/server_check/e_server_check.php');

// Continue with standard implementation
    // Insert/Update
include(DIR_FSROOT.'/html/config/server/w_server.php');
    // Remove all mapped object
include(DIR_FSROOT.'/html/config/server_project/e_server_project_wh_id.php');
include(DIR_FSROOT.'/html/config/server_role/e_server_role_wh_id.php');
include(DIR_FSROOT.'/html/config/server_environment/e_server_environment_wh_id.php');
    // Then delete the server
include(DIR_FSROOT.'/html/config/server/e_server.php');
    // Read and display
include(DIR_FSROOT.'/html/config/server/r_server_wh_id.php');
include(DIR_FSROOT.'/html/config/server/r_server.php');
include(DIR_FSROOT.'/html/config/server/d_server.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_server_clean_class='';
$tab_server_project_class='';
$tab_server_role_class='';
$tab_server_environment_class='';
$tab_server_class='active';

if (isset($_GET['f_id_config_server'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_config_server').'"><button type="button" class="btn btn-primary">'.ADD.' '.SERVER.'</button></a>';
    if (isset($_GET['f_id_config_project']) || $last_action=='edit_project') {
        $tab_server_project_class='active';
        $tab_server_class='';
    }
    elseif (isset($_GET['f_id_config_role']) || $last_action=='edit_role') {
        $tab_server_role_class='active';
        $tab_server_class='';
    }
    elseif (isset($_GET['f_id_config_environment']) || $last_action=='edit_environment') {
        $tab_server_environment_class='active';
        $tab_server_class='';
    }
}
if ($last_action=='clean_server') {
        $tab_server_clean_class='active';
        $tab_server_class='';
}

if (isset($cur_server)) {
    $server_href='edit';
    $server_title=EDIT.' '.SERVER;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_server_clean_class.'"><a href="#server_clean" role="tab" data-toggle="tab">'.CLEAN_SERVER.'</a></li>
          <li class="'.$tab_server_class.'"><a href="#server_'.$server_href.'" role="tab" data-toggle="tab">'.$server_title.'</a></li>
          <li class="'.$tab_server_project_class.'"><a href="#server_project" role="tab" data-toggle="tab">'.PROJECT.'</a></li>
          <li class="'.$tab_server_role_class.'"><a href="#server_role" role="tab" data-toggle="tab">'.ROLE.'</a></li>
          <li class="'.$tab_server_environment_class.'"><a href="#server_environment" role="tab" data-toggle="tab">'.ENV.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $server_href='add';
    $server_title=ADD.' '.SERVER;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_server_clean_class.'"><a href="#server_clean" role="tab" data-toggle="tab">'.CLEAN_SERVER.'</a></li>
          <li class="active"><a href="#server_'.$server_href.'" role="tab" data-toggle="tab">'.$server_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_server_class.'" id="server_'.$server_href.'"><fieldset>';
if (isset($_GET['f_id_config_server'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/config/server/f_server.php');
echo '</fieldset></div>';

/* Clean */
echo '<div class="tab-pane '.$tab_server_clean_class.'" id="server_clean"><fieldset>';
echo '<legend>'.CLEAN_SERVER.'</legend>';
include(DIR_FSROOT.'/html/config/server_check/r_server_check.php');
include(DIR_FSROOT.'/html/config/server_check/f_server_check.php');
echo '</fieldset></div>';
/* End Clean */

if (isset($_GET['f_id_config_server'])) {
    /* SERVER PROJECT */
    echo '<div class="tab-pane '.$tab_server_project_class.'" id="server_project"><fieldset>';
    echo '<legend>'.PROJECTS.'</legend>';
    include(DIR_FSROOT.'/html/config/server_project/w_server_project.php');
    include(DIR_FSROOT.'/html/config/server_project/e_server_project.php');
    include(DIR_FSROOT.'/html/config/server_project/r_server_project_wh_id.php');
    include(DIR_FSROOT.'/html/config/server_project/r_server_project.php');
    include(DIR_FSROOT.'/html/config/server_project/d_server_project.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_project'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_project').'&amp;last_action=edit_project"><button type="button" class="btn btn-primary">'.ADD.' '.PROJECT.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/server_project/f_server_project.php');
    echo '</div>';

    /* SERVER ROLE */
    echo '<div class="tab-pane '.$tab_server_role_class.'" id="server_role"><fieldset>';
    echo '<legend>'.ROLES.'</legend>';
    include(DIR_FSROOT.'/html/config/server_role/w_server_role.php');
    include(DIR_FSROOT.'/html/config/server_role/e_server_role.php');
    include(DIR_FSROOT.'/html/config/server_role/r_server_role_wh_id.php');
    include(DIR_FSROOT.'/html/config/server_role/r_server_role.php');
    include(DIR_FSROOT.'/html/config/server_role/d_server_role.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_role'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_role').'&amp;last_action=edit_role"><button type="button" class="btn btn-primary">'.ADD.' '.ROLE.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/server_role/f_server_role.php');
    echo '</div>';

    /* SERVER ENV */
    echo '<div class="tab-pane '.$tab_server_environment_class.'" id="server_environment"><fieldset>';
    echo '<legend>'.ENV.'</legend>';
    include(DIR_FSROOT.'/html/config/server_environment/w_server_environment.php');
    include(DIR_FSROOT.'/html/config/server_environment/e_server_environment.php');
    include(DIR_FSROOT.'/html/config/server_environment/r_server_environment_wh_id.php');
    include(DIR_FSROOT.'/html/config/server_environment/r_server_environment.php');
    include(DIR_FSROOT.'/html/config/server_environment/d_server_environment.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_environment'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_environment').'&amp;last_action=edit_environment"><button type="button" class="btn btn-primary">'.ADD.' '.ENV.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/server_environment/f_server_environment.php');
    echo '</div>';
}        
echo '</div>';
echo '<div class="clearfix"></div>';
?>
