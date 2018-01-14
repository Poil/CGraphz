<?php
echo '<h1>'.MANAGE_PROJECTS.'</h1>';
include(DIR_FSROOT.'/html/config/project/w_project.php');
include(DIR_FSROOT.'/html/config/project_server/e_project_server_wh_id.php');
include(DIR_FSROOT.'/html/perm/project_group/e_project_group_wh_id.php');
include(DIR_FSROOT.'/html/config/project/e_project.php');
include(DIR_FSROOT.'/html/config/project/r_project_wh_id.php');
include(DIR_FSROOT.'/html/config/project/r_project.php');
include(DIR_FSROOT.'/html/config/project/d_project.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_project_server_class='';
$tab_project_group_class='';
$tab_project_class='active';

if (isset($_GET['f_id_config_project'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_config_project').'"><button type="button" class="btn btn-primary">'.ADD.' '.PROJECT.'</button></a>';
    if (isset($_GET['f_id_config_server']) || $last_action=='edit_server') {
        $tab_project_server_class='active';
        $tab_project_class='';
    }
    else if (isset($_GET['f_id_auth_group']) || $last_action=='edit_group') {
        $tab_project_group_class='active';
        $tab_project_class='';
    }
}

if (isset($cur_project)) {
    $project_href='edit';
    $project_title=EDIT.' '.PROJECT;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_project_class.'"><a href="#project_'.$project_href.'" role="tab" data-toggle="tab">'.$project_title.'</a></li>
          <li class="'.$tab_project_group_class.'"><a href="#project_group" role="tab" data-toggle="tab">'.GROUP.'</a></li>
          <li class="'.$tab_project_server_class.'" ><a href="#project_server" role="tab" data-toggle="tab">'.SERVER.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $project_href='add';
    $project_title=ADD.' '.PROJECT;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#project_'.$project_href.'" role="tab" data-toggle="tab">'.$project_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_project_class.'" id="project_'.$project_href.'"><fieldset>';
echo '<legend>'.PROJECT.'</legend>';
echo '<fieldset>';
if (isset($_GET['f_id_config_project'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/config/project/f_project.php');
echo '</fieldset>';
echo '</fieldset></div>';

if (isset($_GET['f_id_config_project'])) {
    echo '<div class="tab-pane '.$tab_project_group_class.'" id="project_group"><fieldset>';
    echo '<legend>'.PROJECT_PERMS.'</legend>';
    include(DIR_FSROOT.'/html/perm/project_group/w_project_group.php');
    include(DIR_FSROOT.'/html/perm/project_group/e_project_group.php');
    include(DIR_FSROOT.'/html/perm/project_group/r_project_group_wh_id.php');
    include(DIR_FSROOT.'/html/perm/project_group/r_project_group.php');
    include(DIR_FSROOT.'/html/perm/project_group/d_project_group.php');
    echo '<div class="clearfix"></div>';

    if (isset($_GET['f_id_auth_group'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_auth_group').'&amp;last_action=edit_group"><button type="button" class="btn btn-primary">'.ADD.' '.GROUP.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/perm/project_group/f_project_group.php');

    echo '</div>';

    echo '<div class="tab-pane '.$tab_project_server_class.'" id="project_server"><fieldset>';
    echo '<legend>'.PROJECT_SERVERS.'</legend>';
    include(DIR_FSROOT.'/html/config/project_server/w_project_server.php');
    include(DIR_FSROOT.'/html/config/project_server/e_project_server.php');
    include(DIR_FSROOT.'/html/config/project_server/r_project_server_wh_id.php');
    include(DIR_FSROOT.'/html/config/project_server/r_project_server.php');
    include(DIR_FSROOT.'/html/config/project_server/d_project_server.php');
    echo '<div class="clearfix"></div>';

    if (isset($_GET['f_id_config_server'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_server').'&amp;last_action=edit_server"><button type="button" class="btn btn-primary">'.ADD.' '.SERVER.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/project_server/f_project_server.php');
    echo '</div>';
}
echo '</div>';
echo '<div class="clearfix"></div>';
?>
