<?php 
/*
function removeqsvar($url, $varname) {
    return str_replace('&','&amp;',preg_replace('/[?&]'.$varname.'=[^&]+(&|$)/' ,'' , $url));
}
*/
function removeqsvar($url, $varname) {
    if (is_array($varname)) {
        foreach ($varname as $cur_var) {
            $url=preg_replace('/([?&])'.$cur_var.'=[^&]+(&|$)/','$1',$url);
        }
    } else {
        $url=preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
    }
    return htmlspecialchars($url);
}


$cur_url=$_SERVER["REQUEST_URI"];
$module=GET('module');
$component=GET('component');
$workflow=GET('workflow');

$perm_mod = new PERMS();
if ($perm_mod->perm_module($module, $component)) { // DEBUT PERM MODULE

    if ($module=='config') {
        if ($component=='project') {
            include(DIR_FSROOT.'/view/backend/v_project.php');
        } elseif ($component=='server') {
            include(DIR_FSROOT.'/view/backend/v_server.php');
        } else if ($component=='role') {
            include(DIR_FSROOT.'/view/backend/v_role.php');
        } else if ($component=='environment') {
            include(DIR_FSROOT.'/view/backend/v_environment.php');
        } else if ($component=='plugin') {
            include(DIR_FSROOT.'/view/backend/v_plugin_filter.php');
        } else if ($component=='dynamic_dashboard') {
            include(DIR_FSROOT.'/view/backend/v_dynamic_dashboard.php');
        }
    } else if ($module=='auth') {
        if ($component=='user') {
            include(DIR_FSROOT.'/view/backend/v_user.php');
        } else if ($component=='group') {
            include(DIR_FSROOT.'/view/backend/v_group.php');
        }
    } else if ($module=='perm') {
        if ($component=='module') {
            include(DIR_FSROOT.'/view/backend/v_module.php');
        } 
    } else if ($module=='dashboard') {
        if ($component=='view') {
            if (isset($_GET['f_id_config_server'])) {
                include(DIR_FSROOT.'/modules/preg_find.php');
                include(DIR_FSROOT.'/html/config/server/r_server_wh_id.php');
                include(DIR_FSROOT.'/html/dashboard/server_plugins/d_server_plugins.php');            
            }
        } else if ($component == 'dynamic') {
                include(DIR_FSROOT.'/modules/preg_find.php');
                include(DIR_FSROOT.'/html/dashboard/dynamic/r_dynamic.php');
        } else if ($component == 'light') {
                include(DIR_FSROOT.'/modules/preg_find.php');
                include(DIR_FSROOT.'/html/dashboard/dashboard_light/d_dashboard_light.php');
        }
    } else if ($module=='small_admin') {
        if ($component=='mygroup') {
            echo '<h1>'.MANAGE_MYGROUP.'</h1>';
            include(DIR_FSROOT.'/html/small_admin/mygroup/w_group.php');
            include(DIR_FSROOT.'/html/small_admin/mygroup/r_group_wh_id.php');
            include(DIR_FSROOT.'/html/small_admin/mygroup/r_group.php');
            include(DIR_FSROOT.'/html/small_admin/mygroup/d_group.php');
            echo '<div class="clearfix"></div>';
            
            if (isset($_GET['f_id_auth_group'])) {
                echo '<a href="'.removeqsvar($cur_url,'f_id_auth_group').'"><button type="button" class="btn btn-primary">'.ADD.' '.GROUP.'</button></a>';
            }
            echo '<div class="clearfix"></div>';
            $perm_grp = new PERMS();
            $f_id_auth_group=intval(GET('f_id_auth_group'));
            if (($f_id_auth_group && $perm_grp->auth_user_group($f_id_auth_group,true)) || !$f_id_auth_group) {
                echo '<fieldset>';
                if (isset($cur_group)) {
                    echo '<legend>'.$cur_group->group.'</legend>';
                }
                echo '<fieldset>';
                if (isset($_GET['f_id_auth_group'])) {
                    echo '<legend>'.EDIT.'</legend>';
                }
                else {
                    echo '<legend>'.ADD.'</legend>';
                }
            
                include(DIR_FSROOT.'/html/small_admin/mygroup/f_group.php');
                echo '</fieldset>';
                
                if (isset($_GET['f_id_auth_group'])) {
                    echo '<fieldset>';
                    echo '<legend>'.USERS.'</legend>';
                    include(DIR_FSROOT.'/html/small_admin/mygroup_user/w_group_user.php');
                    include(DIR_FSROOT.'/html/small_admin/mygroup_user/e_group_user.php');
                    include(DIR_FSROOT.'/html/small_admin/mygroup_user/r_group_user_wh_id.php');
                    include(DIR_FSROOT.'/html/small_admin/mygroup_user/r_group_user.php');
                    include(DIR_FSROOT.'/html/small_admin/mygroup_user/d_group_user.php');
                    echo '<div class="clearfix"></div>';
                    
                    if (isset($_GET['f_id_auth_user'])) {
                        echo '<a href="'.removeqsvar($cur_url,'f_id_auth_user').'"><button type="button" class="btn btn-primary">'.ADD.' '.USER.'</button></a>';
                    }
                    echo '<div class="clearfix"></div>';
                    if (isset($_GET['f_id_auth_user'])) {
                        echo '<strong>'.DEL.'</strong>';
                    } else {
                        echo '<strong>'.ADD.'</strong>';
                    }
                    include(DIR_FSROOT.'/html/small_admin/mygroup_user/f_group_user.php');
                    echo '</fieldset>';
                }
                echo '</fieldset>';
            }
            echo '<div class="clearfix"></div>';
        } else if ($component=='myaccount') {
            echo '<h1>'.MY_ACCOUNT.'</h1>';
            echo '<fieldset>';
            echo '<legend>'.EDIT.'</legend>';
            include(DIR_FSROOT.'/html/small_admin/myaccount/w_myaccount.php');
            include(DIR_FSROOT.'/html/small_admin/myaccount/r_myaccount_wh_id.php');
            include(DIR_FSROOT.'/html/small_admin/myaccount/f_myaccount.php');
            echo '</fieldset>';
        } else if ($component=='newuser') {
            echo '<h1>'.ADD_USER.'</h1>';
            echo '<fieldset>';
            echo '<legend>'.EDIT.'</legend>';
            include(DIR_FSROOT.'/html/small_admin/newuser/w_user.php');
            include(DIR_FSROOT.'/html/small_admin/newuser/f_user.php');
            echo '</fieldset>';
        } else if ($component=='mydashboard') {
            include(DIR_FSROOT.'/view/backend/v_small_admin_mydashboard.php');
        }
    } else {
        echo $CONFIG['welcome_text'];
    } 
} else {
    if ($component && $module) {
        echo '<br />'.NO_ACCESS.'<br />';
    }
}
?>
