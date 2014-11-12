<?php
echo '<h1>'.MANAGE_MY_DYN_DASHBOARDS.'</h1>';
include(DIR_FSROOT.'/html/small_admin/mydashboard/w_dynamic_dashboard.php');
include(DIR_FSROOT.'/html/small_admin/mydashboard/e_dynamic_dashboard.php');
include(DIR_FSROOT.'/html/small_admin/mydashboard/r_dynamic_dashboard_wh_id.php');
include(DIR_FSROOT.'/html/small_admin/mydashboard/r_dynamic_dashboard.php');
include(DIR_FSROOT.'/html/small_admin/mydashboard/d_dynamic_dashboard.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_dynamic_dashboard_content_class='';
$tab_dynamic_dashboard_class='active';

if (isset($_GET['f_id_config_dynamic_dashboard'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_config_dynamic_dashboard').'"><button type="button" class="btn btn-primary">'.ADD.' '.DASHBOARD.'</button></a>';
    if (isset($_GET['f_id_config_dynamic_dashboard_content']) || $last_action=='edit_content') {
        $tab_dynamic_dashboard_content_class='active';
        $tab_dynamic_dashboard_class='';
    }
}

if (isset($cur_dynamic_dashboard)) {
    $dynamic_dashboard_href='edit';
    $dynamic_dashboard_title=EDIT.' '.DASHBOARD;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_dynamic_dashboard_class.'"><a href="#dynamic_dashboard_'.$dynamic_dashboard_href.'" role="tab" data-toggle="tab">'.$dynamic_dashboard_title.'</a></li>
          <li class="'.$tab_dynamic_dashboard_content_class.'" ><a href="#dynamic_dashboard_content" role="tab" data-toggle="tab">'.CONTENT.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $dynamic_dashboard_href='add';
    $dynamic_dashboard_title=ADD.' '.DASHBOARD;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#dynamic_dashboard_'.$dynamic_dashboard_href.'" role="tab" data-toggle="tab">'.$dynamic_dashboard_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_dynamic_dashboard_class.'" id="dynamic_dashboard_'.$dynamic_dashboard_href.'"><fieldset>';
echo '<legend>'.DASHBOARD.'</legend>';
echo '<fieldset>';
if (isset($_GET['f_id_config_dynamic_dashboard'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/small_admin/mydashboard/f_dynamic_dashboard.php');
echo '</fieldset>';
echo '</fieldset></div>';

if (isset($_GET['f_id_config_dynamic_dashboard'])) {
    /* content */
    echo '<div class="tab-pane '.$tab_dynamic_dashboard_content_class.'" id="dynamic_dashboard_content"><fieldset>';
    echo '<legend>'.CONTENT.'</legend>';
    include(DIR_FSROOT.'/html/small_admin/mydashboard_content/w_dynamic_dashboard_content.php');
    include(DIR_FSROOT.'/html/small_admin/mydashboard_content/e_dynamic_dashboard_content.php');
    include(DIR_FSROOT.'/html/small_admin/mydashboard_content/r_dynamic_dashboard_content_wh_id.php');
    include(DIR_FSROOT.'/html/small_admin/mydashboard_content/r_dynamic_dashboard_content.php');
    include(DIR_FSROOT.'/html/small_admin/mydashboard_content/d_dynamic_dashboard_content.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_dynamic_dashboard_content').'&amp;last_action=edit_content"><button type="button" class="btn btn-primary">'.ADD.' '.CONTENT.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/small_admin/mydashboard_content/f_dynamic_dashboard_content.php');
    echo '</fieldset>';
    echo '</div>';
}        
echo '</div>';
echo '<div class="clearfix"></div>';
?>
