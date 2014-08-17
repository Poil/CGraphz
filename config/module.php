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
            echo '<h1>'.MANAGE_ROLES.'</h1>';
            include(DIR_FSROOT.'/html/config/role/w_role.php');
            include(DIR_FSROOT.'/html/config/role_server/e_role_server_wh_id.php');
            include(DIR_FSROOT.'/html/config/role/e_role.php');
            include(DIR_FSROOT.'/html/config/role/r_role_wh_id.php');
            include(DIR_FSROOT.'/html/config/role/r_role.php');
            include(DIR_FSROOT.'/html/config/role/d_role.php');
            echo '<div class="clearfix"></div>';
            
            if (isset($_GET['f_id_config_role'])) {
                echo '<a href="'.removeqsvar($cur_url,'f_id_config_role').'"><button type="button" class="btn btn-primary">'.ADD.' '.ROLE.'</button></a>';
            }
            echo '<div class="clearfix"></div>';
            echo '<fieldset>';
            if (isset($cur_role)) {
                echo '<legend>'.$cur_role->role_description.'</legend>';
            }
            echo '<fieldset>';
            if (isset($_GET['f_id_config_role'])) {
                echo '<legend>'.EDIT.'</legend>';
            }
            else {
                echo '<legend>'.ADD.'</legend>';
            }
            include(DIR_FSROOT.'/html/config/role/f_role.php');
            echo '</fieldset>';
            if (isset($_GET['f_id_config_role'])) {
                echo '<fieldset>';
                echo '<legend>'.ROLES.'</legend>';
                include(DIR_FSROOT.'/html/config/role_server/w_role_server.php');
                include(DIR_FSROOT.'/html/config/role_server/e_role_server.php');
                include(DIR_FSROOT.'/html/config/role_server/r_role_server_wh_id.php');
                include(DIR_FSROOT.'/html/config/role_server/r_role_server.php');
                include(DIR_FSROOT.'/html/config/role_server/d_role_server.php');
                echo '<div class="clearfix"></div>';
                
                if (isset($_GET['f_id_config_server'])) {
                    echo '<a href="'.removeqsvar($cur_url,'f_id_config_server').'"><button type="button" class="btn btn-primary">'.ADD.' '.SERVER.'</button></a>';
                }
                echo '<div class="clearfix"></div>';
                if (isset($_GET['f_id_config_server'])) {
                    echo '<legend>'.DEL.'</legend>';
                }
                else {
                    echo '<legend>'.ADD.'</legend>';
                }
                include(DIR_FSROOT.'/html/config/role_server/f_role_server.php');
                echo '</fieldset>';
            }
            echo '</fieldset>';
            echo '<div class="clearfix"></div>';
        } else if ($component=='environment') {
            echo '<h1>'.MANAGE_ENVS.'</h1>';
            include(DIR_FSROOT.'/html/config/environment/w_environment.php');
            include(DIR_FSROOT.'/html/config/environment_server/e_environment_server_wh_id.php');
            include(DIR_FSROOT.'/html/config/environment/e_environment.php');
            include(DIR_FSROOT.'/html/config/environment/r_environment_wh_id.php');
            include(DIR_FSROOT.'/html/config/environment/r_environment.php');
            include(DIR_FSROOT.'/html/config/environment/d_environment.php');
            echo '<div class="clearfix"></div>';
            
            if (isset($_GET['f_id_config_environment'])) {
                echo '<a href="'.removeqsvar($cur_url,'f_id_config_environment').'"><button type="button" class="btn btn-primary">'.ADD.' '.ENV.'</button></a>';
            }
            echo '<div class="clearfix"></div>';
            echo '<fieldset>';
            if (isset($cur_environment)) {
                echo '<legend>'.$cur_environment->environment_description.'</legend>';
            }
            echo '<fieldset>';
            if (isset($_GET['f_id_config_environment'])) {
                echo '<legend>'.EDIT.'</legend>';
            }
            else {
                echo '<legend>'.ADD.'</legend>';
            }
            include(DIR_FSROOT.'/html/config/environment/f_environment.php');
            echo '</fieldset>';
            if (isset($_GET['f_id_config_environment'])) {
                echo '<fieldset>';
                echo '<legend>'.ENVS.'</legend>';
                include(DIR_FSROOT.'/html/config/environment_server/w_environment_server.php');
                include(DIR_FSROOT.'/html/config/environment_server/e_environment_server.php');
                include(DIR_FSROOT.'/html/config/environment_server/r_environment_server_wh_id.php');
                include(DIR_FSROOT.'/html/config/environment_server/r_environment_server.php');
                include(DIR_FSROOT.'/html/config/environment_server/d_environment_server.php');
                echo '<div class="clearfix"></div>';
                
                if (isset($_GET['f_id_config_server'])) {
                    echo '<a href="'.removeqsvar($cur_url,'f_id_config_server').'"><button type="button" class="btn btn-primary">'.ADD.' '.SERVER.'</button></a>';
                }
                echo '<div class="clearfix"></div>';
                if (isset($_GET['f_id_config_server'])) {
                    echo '<legend>'.DEL.'</legend>';
                }
                else {
                    echo '<legend>'.ADD.'</legend>';
                }
                include(DIR_FSROOT.'/html/config/environment_server/f_environment_server.php');
                echo '</fieldset>';
            }
            echo '</fieldset>';
            echo '<div class="clearfix"></div>';
        } else if ($component=='plugin') {
            echo '<h1>'.MANAGE_PLUGINS.'</h1>';
            include(DIR_FSROOT.'/html/config/plugin_filter/w_plugin_filter.php');
            include(DIR_FSROOT.'/html/config/plugin_filter/e_plugin_filter.php');
            include(DIR_FSROOT.'/html/config/plugin_filter/r_plugin_filter_wh_id.php');
            include(DIR_FSROOT.'/html/config/plugin_filter/r_plugin_filter.php');
            include(DIR_FSROOT.'/html/config/plugin_filter/d_plugin_filter.php');
            echo '<div class="clearfix"></div>';
            
            if (isset($_GET['f_id_config_plugin_filter'])) {
                echo '<a href="'.removeqsvar($cur_url,'f_id_config_plugin_filter').'"><button type="button" class="btn btn-primary">'.ADD.' '.PLUGIN.'</button></a>';
            }
            echo '<div class="clearfix"></div>';
            echo '<fieldset>';
            if (isset($cur_plugin_filter)) {
                echo '<legend>'.$cur_plugin_filter->plugin_filter_desc.'</legend>';
            }
            echo '<fieldset>';
            if (isset($_GET['f_id_config_plugin_filter'])) {
                echo '<legend>'.EDIT.'</legend>';
            }
            else {
                echo '<legend>'.ADD.'</legend>';
            }
            include(DIR_FSROOT.'/html/config/plugin_filter/f_plugin_filter.php');
            echo '</fieldset>';
            echo '</fieldset>';
            echo '<div class="clearfix"></div>';
        } else if ($component=='dynamic_dashboard') {
            echo '<h1>'.MANAGE_DYNAMIC_DASHBOARDS.'</h1>';
            include(DIR_FSROOT.'/html/config/dynamic_dashboard/w_dynamic_dashboard.php');
            include(DIR_FSROOT.'/html/config/dynamic_dashboard_group/e_dynamic_dashboard_group_wh_id.php');
            include(DIR_FSROOT.'/html/config/dynamic_dashboard_content/e_dynamic_dashboard_content_wh_id.php');
            include(DIR_FSROOT.'/html/config/dynamic_dashboard/e_dynamic_dashboard.php');
            include(DIR_FSROOT.'/html/config/dynamic_dashboard/r_dynamic_dashboard_wh_id.php');
            include(DIR_FSROOT.'/html/config/dynamic_dashboard/r_dynamic_dashboard.php');
            include(DIR_FSROOT.'/html/config/dynamic_dashboard/d_dynamic_dashboard.php');
            echo '<div class="clearfix"></div>';
            
            if (isset($_GET['f_id_config_dynamic_dashboard'])) {
                echo '<a href="'.removeqsvar($cur_url,'f_id_config_dynamic_dashboard').'"><button type="button" class="btn btn-primary">'.ADD.' '.DYNAMIC_DASHBOARD.'</button></a>';
            }
            echo '<div class="clearfix"></div>';
            echo '<fieldset>';
            if (isset($cur_dynamic_dashboard)) {
                echo '<legend>'.$cur_dynamic_dashboard->title.'</legend>';
            }
            echo '<fieldset>';
            if (isset($_GET['f_id_config_dynamic_dashboard'])) {
                echo '<legend>'.EDIT.'</legend>';
            }
            else {
                echo '<legend>'.ADD.'</legend>';
            }
            include(DIR_FSROOT.'/html/config/dynamic_dashboard/f_dynamic_dashboard.php');
            echo '</fieldset>';
            if (isset($_GET['f_id_config_dynamic_dashboard'])) {
                echo '<fieldset>';
                echo '<legend>'.GROUPS.'</legend>';
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_group/w_dynamic_dashboard_group.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_group/e_dynamic_dashboard_group.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_group/r_dynamic_dashboard_group_wh_id.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_group/r_dynamic_dashboard_group.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_group/d_dynamic_dashboard_group.php');
                echo '<div class="clearfix"></div>';
                
                if (isset($_GET['f_id_config_dynamic_dashboard_group'])) {
                    echo '<a href="'.removeqsvar($cur_url,'f_id_config_dynamic_dashboard_group').'"><button type="button" class="btn btn-primary">'.ADD.' '.GROUPS.'</button></a>';
                }
                echo '<div class="clearfix"></div>';
                if (isset($_GET['f_id_config_dynamic_dashboard_group'])) {
                    echo '<legend>'.EDIT.'</legend>';
                }
                else {
                    echo '<legend>'.ADD.'</legend>';
                }
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_group/f_dynamic_dashboard_group.php');
                echo '</fieldset>';
            }
            
            if (isset($_GET['f_id_config_dynamic_dashboard'])) {
                echo '<fieldset class="large">';
                echo '<legend>'.CONTENT.'</legend>';
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_content/w_dynamic_dashboard_content.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_content/e_dynamic_dashboard_content.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_content/r_dynamic_dashboard_content_wh_id.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_content/r_dynamic_dashboard_content.php');
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_content/d_dynamic_dashboard_content.php');
                echo '<div class="clearfix"></div>';
                
                if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
                    echo '<a href="'.removeqsvar($cur_url,'f_id_config_dynamic_dashboard_content').'"><button type="button" class="btn btn-primary">'.ADD.' '.CONTENT.'</button></a>';
                }
                echo '<div class="clearfix"></div>';
                if (isset($_GET['f_id_config_dynamic_dashboard_content'])) {
                    echo '<legend>'.EDIT.'</legend>';
                }
                else {
                    echo '<legend>'.ADD.'</legend>';
                }
                include(DIR_FSROOT.'/html/config/dynamic_dashboard_content/f_dynamic_dashboard_content.php');
                echo '</fieldset>';
            }
            
            echo '</fieldset>';
            echo '<div class="clearfix"></div>';
        }
    } else if ($module=='auth') {
        if ($component=='user') {
            include(DIR_FSROOT.'/view/backend/v_user.php');
        }
        else if ($component=='group') {
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
                    }
                    else {
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
            echo '<h1>'.MANAGE_MY_DYN_DASHBOARDS.'</h1>';
            include(DIR_FSROOT.'/html/small_admin/mydashboard/r_dynamic_dashboard_wh_id.php');
            include(DIR_FSROOT.'/html/small_admin/mydashboard/e_dynamic_dashboard.php');
            include(DIR_FSROOT.'/html/small_admin/mydashboard/w_dynamic_dashboard.php');
            include(DIR_FSROOT.'/html/small_admin/mydashboard/r_dynamic_dashboard_wh_id.php');
            include(DIR_FSROOT.'/html/small_admin/mydashboard/r_dynamic_dashboard.php');
            include(DIR_FSROOT.'/html/small_admin/mydashboard/d_dynamic_dashboard.php');
            echo '<div class="clearfix"></div>';
            
            if (isset($_GET['f_id_config_dynamic_dashboard'])) {
                echo '<a href="'.removeqsvar($cur_url,'f_id_config_dynamic_dashboard').'"><button type="button" class="btn btn-primary">'.ADD.' '.DASHBOARD.'</button></a>';
            }
            echo '<div class="clearfix"></div>';
            $f_id_config_dynamic_dashboard=intval(GET('f_id_config_dynamic_dashboard'));
            echo '<fieldset>';
            if (isset($cur_dynamic_dashboard)) {
                echo '<legend>'.$cur_dynamic_dashboard->title.'</legend>';
            }
            echo '<fieldset>';
            if (isset($_GET['f_id_config_dynamic_dashboard'])) {
                echo '<legend>'.EDIT.'</legend>';
            }
            else {
                echo '<legend>'.ADD.'</legend>';
            }
            
            include(DIR_FSROOT.'/html/small_admin/mydashboard/f_dynamic_dashboard.php');
            echo '</fieldset>';
            
            if (isset($_GET['f_id_config_dynamic_dashboard'])) {
                echo '<fieldset class="large">';
                echo '<legend>'.PLUGIN_FILTER.'</legend>';
                include(DIR_FSROOT.'/html/small_admin/mydashboard_content/w_dynamic_dashboard_content.php');
                include(DIR_FSROOT.'/html/small_admin/mydashboard_content/e_dynamic_dashboard_content.php');
                include(DIR_FSROOT.'/html/small_admin/mydashboard_content/r_dynamic_dashboard_content_wh_id.php');
                include(DIR_FSROOT.'/html/small_admin/mydashboard_content/r_dynamic_dashboard_content.php');
                include(DIR_FSROOT.'/html/small_admin/mydashboard_content/d_dynamic_dashboard_content.php');
                echo '<div class="clearfix"></div>';
                
                if (isset($_GET['f_id_auth_user'])) {
                    echo '<a href="'.removeqsvar($cur_url,'f_id_auth_user').'"><button type="button" class="btn btn-primary">'.ADD.' '.USER.'</button></a>';
                }
                echo '<div class="clearfix"></div>';
                if (isset($_GET['f_id_auth_user'])) {
                    echo '<strong>'.DEL.'</strong>';
                }
                else {
                    echo '<strong>'.ADD.'</strong>';
                }
                include(DIR_FSROOT.'/html/small_admin/mydashboard_content/f_dynamic_dashboard_content.php');
                echo '</fieldset>';
            }
            echo '</fieldset>';
            echo '<div class="clearfix"></div>';
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
