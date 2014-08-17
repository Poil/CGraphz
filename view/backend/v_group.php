<?php
echo '<h1>'.MANAGE_GROUPS.'</h1>';
include(DIR_FSROOT.'/html/auth/group/w_group.php');
include(DIR_FSROOT.'/html/auth/group_user/e_group_user_wh_id.php');
include(DIR_FSROOT.'/html/config/group_dynamic_dashboard/e_group_dynamic_dashboard_wh_id.php');
include(DIR_FSROOT.'/html/perm/group_module/e_group_module_wh_id.php');
include(DIR_FSROOT.'/html/config/group_plugin_filter/e_group_plugin_filter_wh_id.php');
include(DIR_FSROOT.'/html/perm/group_project/e_group_project_wh_id.php');
include(DIR_FSROOT.'/html/auth/group/e_group.php');
include(DIR_FSROOT.'/html/auth/group/r_group_wh_id.php');
include(DIR_FSROOT.'/html/auth/group/r_group.php');
include(DIR_FSROOT.'/html/auth/group/d_group.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_group_user_class='';
$tab_group_project_class='';
$tab_group_plugin_filter_class='';
$tab_group_module_class='';
$tab_group_dynamic_dashboard_class='';
$tab_group_class='active';

if (isset($_GET['f_id_auth_group'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_auth_group').'"><button type="button" class="btn btn-primary">'.ADD.' '.GROUP.'</button></a>';
    if (isset($_GET['f_id_auth_user']) || $last_action=='edit_user') {
        $tab_group_user_class='active';
        $tab_group_class='';
    }
    elseif (isset($_GET['f_id_config_project']) || $last_action=='edit_project') {
        $tab_group_project_class='active';
        $tab_group_class='';
    }
    elseif (isset($_GET['f_id_config_plugin_filter']) || $last_action=='edit_plugin_filter') {
        $tab_group_plugin_filter_class='active';
        $tab_group_class='';
    }
    elseif (isset($_GET['f_id_perm_module']) || $last_action=='edit_module') {
        $tab_group_module_class='active';
        $tab_group_class='';
    }
    elseif (isset($_GET['f_id_config_dynamic_dashboard']) || $last_action=='edit_dynamic_dashboard') {
        $tab_group_dynamic_dashboard_class='active';
        $tab_group_class='';
    }
}

if (isset($cur_group)) {
    $group_href='edit';
    $group_title=EDIT.' '.GROUP;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_group_class.'"><a href="#group_'.$group_href.'" role="tab" data-toggle="tab">'.$group_title.'</a></li>
          <li class="'.$tab_group_user_class.'"><a href="#group_user" role="tab" data-toggle="tab">'.USER.'</a></li>
          <li class="'.$tab_group_project_class.'"><a href="#group_project" role="tab" data-toggle="tab">'.PROJECT.'</a></li>
          <li class="'.$tab_group_plugin_filter_class.'"><a href="#group_plugin_filter" role="tab" data-toggle="tab">'.PLUGIN_FILTER.'</a></li>
          <li class="'.$tab_group_module_class.'"><a href="#group_module" role="tab" data-toggle="tab">'.PERMS.'</a></li>
          <li class="'.$tab_group_dynamic_dashboard_class.'"><a href="#group_dynamic_dashboard" role="tab" data-toggle="tab">'.DYNAMIC_DASHBOARDS.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $group_href='add';
    $group_title=ADD.' '.GROUP;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#group_'.$group_href.'" role="tab" data-toggle="tab">'.$group_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_group_class.'" id="group_'.$group_href.'"><fieldset>';
if (isset($_GET['f_id_auth_group'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/auth/group/f_group.php');
echo '</fieldset></div>';

if (isset($_GET['f_id_auth_group'])) {
    /* GROUP USER */
    echo '<div class="tab-pane '.$tab_group_user_class.'" id="group_user"><fieldset>';
    echo '<legend>'.USERS.'</legend>';
    include(DIR_FSROOT.'/html/auth/group_user/w_group_user.php');
    include(DIR_FSROOT.'/html/auth/group_user/e_group_user.php');
    include(DIR_FSROOT.'/html/auth/group_user/r_group_user_wh_id.php');
    include(DIR_FSROOT.'/html/auth/group_user/r_group_user.php');
    include(DIR_FSROOT.'/html/auth/group_user/d_group_user.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_auth_user'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_auth_user').'&amp;last_action=edit_user"><button type="button" class="btn btn-primary">'.ADD.' '.USER.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    echo '<fieldset>';
    echo '<legend>'.EDIT.'</legend>';
    include(DIR_FSROOT.'/html/auth/group_user/f_group_user.php');
    echo '</fieldset>';
    
    echo '</div>';

    /* GROUP PROJECT */
    echo '<div class="tab-pane '.$tab_group_project_class.'" id="group_project"><fieldset>';
    echo '<legend>'.PROJECTS.'</legend>';
    include(DIR_FSROOT.'/html/perm/group_project/w_group_project.php');
    include(DIR_FSROOT.'/html/perm/group_project/e_group_project.php');
    include(DIR_FSROOT.'/html/perm/group_project/r_group_project_wh_id.php');
    include(DIR_FSROOT.'/html/perm/group_project/r_group_project.php');
    include(DIR_FSROOT.'/html/perm/group_project/d_group_project.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_project'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_project').'&amp;last_action=edit_project"><button type="button" class="btn btn-primary">'.ADD.' '.PROJECT.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/perm/group_project/f_group_project.php');
    echo '</div>';

    /* GROUP PLUGIN FILTER */
    echo '<div class="tab-pane '.$tab_group_plugin_filter_class.'" id="group_plugin_filter"><fieldset>';
    echo '<legend>'.PLUGIN_FILTER.'</legend>';
    include(DIR_FSROOT.'/html/config/group_plugin_filter/w_group_plugin_filter.php');
    include(DIR_FSROOT.'/html/config/group_plugin_filter/e_group_plugin_filter.php');
    include(DIR_FSROOT.'/html/config/group_plugin_filter/r_group_plugin_filter_wh_id.php');
    include(DIR_FSROOT.'/html/config/group_plugin_filter/r_group_plugin_filter.php');
    include(DIR_FSROOT.'/html/config/group_plugin_filter/d_group_plugin_filter.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_plugin_filter'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_plugin_filter').'&amp;last_action=edit_plugin_filter"><button type="button" class="btn btn-primary">'.ADD.' '.PLUGIN_FILTER.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/group_plugin_filter/f_group_plugin_filter.php');
    echo '</div>';

    /* PERMS */
    echo '<div class="tab-pane '.$tab_group_module_class.'" id="group_module"><fieldset>';
    echo '<legend>'.PERMS.'</legend>';
    include(DIR_FSROOT.'/html/perm/group_module/w_group_module.php');
    include(DIR_FSROOT.'/html/perm/group_module/e_group_module.php');
    include(DIR_FSROOT.'/html/perm/group_module/r_group_module_wh_id.php');
    include(DIR_FSROOT.'/html/perm/group_module/r_group_module.php');
    include(DIR_FSROOT.'/html/perm/group_module/d_group_module.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_perm_module'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_perm_module').'&amp;last_action=edit_module"><button type="button" class="btn btn-primary">'.ADD.' '.MODULE.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/perm/group_module/f_group_module.php');
    echo '</div>';

    /* DYNAMIC DASHBOARD */
    echo '<div class="tab-pane '.$tab_group_dynamic_dashboard_class.'" id="group_dynamic_dashboard"><fieldset>';
    echo '<legend>'.DYNAMIC_DASHBOARDS.'</legend>';
    include(DIR_FSROOT.'/html/config/group_dynamic_dashboard/w_group_dynamic_dashboard.php');
    include(DIR_FSROOT.'/html/config/group_dynamic_dashboard/e_group_dynamic_dashboard.php');
    include(DIR_FSROOT.'/html/config/group_dynamic_dashboard/r_group_dynamic_dashboard_wh_id.php');
    include(DIR_FSROOT.'/html/config/group_dynamic_dashboard/r_group_dynamic_dashboard.php');
    include(DIR_FSROOT.'/html/config/group_dynamic_dashboard/d_group_dynamic_dashboard.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_perm_module'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_dynamic_dashboard').'&amp;last_action=edit_dynamic_dashboard"><button type="button" class="btn btn-primary">'.ADD.' '.DYNAMIC_DASHBOARD.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/group_dynamic_dashboard/f_group_dynamic_dashboard.php');
    
    echo '</div>';
}        
echo '</div>';
echo '<div class="clearfix"></div>';
?>
