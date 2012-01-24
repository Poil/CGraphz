<?php 
/*
function removeqsvar($url, $varname) {
    return str_replace('&','&amp;',preg_replace('/[?&]'.$varname.'=[^&]+(&|$)/' ,'' , $url));
}
*/
function removeqsvar($url, $varname) {
    return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
}


$cur_url=$_SERVER["REQUEST_URI"];
$module=@$_GET['module'];
$component=@$_GET['component'];
$workflow=@$_GET['workflow'];

$perm_mod = new PERMS();
if ($perm_mod->perm_module($module, $component)) { // DEBUT PERM MODULE

if ($module=='config') {
	if ($component=='project') {
		echo '<h1>Gestion des Projets</h1>';
		include(DIR_FSROOT.'/html/config/project/w_project.php');
		include(DIR_FSROOT.'/html/config/project/e_project.php');
		include(DIR_FSROOT.'/html/config/project/r_project_wh_id.php');
		include(DIR_FSROOT.'/html/config/project/r_project.php');
		include(DIR_FSROOT.'/html/config/project/d_project.php');
		
		if (isset($_GET['f_id_config_project'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_project').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_project)) {
			echo '<legend>'.$cur_project->project_description.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_config_project'])) {
			echo '<legend>Editer</legend>';
		} else {
			echo '<legend>Nouveau</legend>';
		}
		include(DIR_FSROOT.'/html/config/project/f_project.php');
		echo '</fieldset>';

		if (isset($_GET['f_id_config_project'])) {
			echo '<fieldset>';
			echo '<legend>Permissions du projet</legend>';
			include(DIR_FSROOT.'/html/perm/project_group/w_project_group.php');
			include(DIR_FSROOT.'/html/perm/project_group/e_project_group.php');
			include(DIR_FSROOT.'/html/perm/project_group/r_project_group_wh_id.php');
			include(DIR_FSROOT.'/html/perm/project_group/r_project_group.php');
			include(DIR_FSROOT.'/html/perm/project_group/d_project_group.php');
			
			if (isset($_GET['f_id_auth_group'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_group').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_auth_group'])) {
				echo '<strong>Suppression</strong>';
			} else {
				echo '<strong>Ajouter</strong>';
			}
			include(DIR_FSROOT.'/html/perm/project_group/f_project_group.php');
			
			echo '</fieldset>';
			echo '<fieldset>';
			echo '<legend>Serveurs du projet</legend>';
			include(DIR_FSROOT.'/html/config/project_server/w_project_server.php');
			include(DIR_FSROOT.'/html/config/project_server/e_project_server.php');
			include(DIR_FSROOT.'/html/config/project_server/r_project_server_wh_id.php');
			include(DIR_FSROOT.'/html/config/project_server/r_project_server.php');
			include(DIR_FSROOT.'/html/config/project_server/d_project_server.php');
			
			if (isset($_GET['f_id_config_server'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_server').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_server'])) {
				echo '<strong>Suppression</strong>';
			} else {
				echo '<strong>Ajouter</strong>';
			}
			include(DIR_FSROOT.'/html/config/project_server/f_project_server.php');
			echo '</fieldset>';
		}		
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';
	} elseif ($component=='server') {
		echo '<h1>Gestion des serveurs</h1>';
		// Module server_check delete post before read.
		include(DIR_FSROOT.'/html/config/server_check/e_server_check.php');
		
		// Continue with standard implementation
		include(DIR_FSROOT.'/html/config/server/w_server.php');
		include(DIR_FSROOT.'/html/config/server/e_server.php');
		include(DIR_FSROOT.'/html/config/server/r_server_wh_id.php');
		include(DIR_FSROOT.'/html/config/server/r_server.php');
		include(DIR_FSROOT.'/html/config/server/d_server.php');
		
		if (isset($_GET['f_id_config_server'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_server').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_server)) {
			echo '<legend>'.$cur_server->server_name.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_config_server'])) {
			echo '<legend>Supprimer</legend>';
		}
		else {
			echo '<legend>Ajouter</legend>';
		}
		include(DIR_FSROOT.'/html/config/server/f_server.php');
		echo '</fieldset>';
		
		if (!isset($_GET['f_id_config_server'])) {
			echo '<fieldset>';
			echo '<legend>Serveur à purger</legend>';
			include(DIR_FSROOT.'/html/config/server_check/r_server_check.php');
			include(DIR_FSROOT.'/html/config/server_check/f_server_check.php');
			echo '</fieldset>';
		}
		
		if (isset($_GET['f_id_config_server'])) {
			echo '<fieldset>';
			echo '<legend>Projets</legend>';
			include(DIR_FSROOT.'/html/config/server_project/w_server_project.php');
			include(DIR_FSROOT.'/html/config/server_project/e_server_project.php');
			include(DIR_FSROOT.'/html/config/server_project/r_server_project_wh_id.php');
			include(DIR_FSROOT.'/html/config/server_project/r_server_project.php');
			include(DIR_FSROOT.'/html/config/server_project/d_server_project.php');
			
			if (isset($_GET['f_id_config_project'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_project').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_project'])) {
				echo '<legend>Supprimer</legend>';
			}
			else {
				echo '<legend>Nouveau</legend>';
			}
			include(DIR_FSROOT.'/html/config/server_project/f_server_project.php');
			echo '</fieldset>';
		}
		
		if (isset($_GET['f_id_config_server'])) {
			echo '<fieldset>';
			echo '<legend>Rôles</legend>';
			include(DIR_FSROOT.'/html/config/server_role/w_server_role.php');
			include(DIR_FSROOT.'/html/config/server_role/e_server_role.php');
			include(DIR_FSROOT.'/html/config/server_role/r_server_role_wh_id.php');
			include(DIR_FSROOT.'/html/config/server_role/r_server_role.php');
			include(DIR_FSROOT.'/html/config/server_role/d_server_role.php');
			
			if (isset($_GET['f_id_config_role'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_role').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_role'])) {
				echo '<legend>Supprimer</legend>';
			}
			else {
				echo '<legend>Nouveau</legend>';
			}
			include(DIR_FSROOT.'/html/config/server_role/f_server_role.php');
			echo '</fieldset>';
		}
		
		if (isset($_GET['f_id_config_server'])) {
			echo '<fieldset>';
			echo '<legend>Environnements</legend>';
			include(DIR_FSROOT.'/html/config/server_environment/w_server_environment.php');
			include(DIR_FSROOT.'/html/config/server_environment/e_server_environment.php');
			include(DIR_FSROOT.'/html/config/server_environment/r_server_environment_wh_id.php');
			include(DIR_FSROOT.'/html/config/server_environment/r_server_environment.php');
			include(DIR_FSROOT.'/html/config/server_environment/d_server_environment.php');
			
			if (isset($_GET['f_id_config_environment'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_role').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_environment'])) {
				echo '<legend>Supprimer</legend>';
			}
			else {
				echo '<legend>Nouveau</legend>';
			}
			include(DIR_FSROOT.'/html/config/server_environment/f_server_environment.php');
			echo '</fieldset>';
		}
		
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';
	} else if ($component=='role') {
		echo '<h1>Gestion des roles</h1>';
		include(DIR_FSROOT.'/html/config/role/w_role.php');
		include(DIR_FSROOT.'/html/config/role/e_role.php');
		include(DIR_FSROOT.'/html/config/role/r_role_wh_id.php');
		include(DIR_FSROOT.'/html/config/role/r_role.php');
		include(DIR_FSROOT.'/html/config/role/d_role.php');
		
		if (isset($_GET['f_id_config_role'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_role').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_role)) {
			echo '<legend>'.$cur_role->role_description.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_config_role'])) {
			echo '<legend>Modifier</legend>';
		}
		else {
			echo '<legend>Ajouter</legend>';
		}
		include(DIR_FSROOT.'/html/config/role/f_role.php');
		echo '</fieldset>';
		if (isset($_GET['f_id_config_role'])) {
			echo '<fieldset>';
			echo '<legend>Rôles</legend>';
			include(DIR_FSROOT.'/html/config/role_server/w_role_server.php');
			include(DIR_FSROOT.'/html/config/role_server/e_role_server.php');
			include(DIR_FSROOT.'/html/config/role_server/r_role_server_wh_id.php');
			include(DIR_FSROOT.'/html/config/role_server/r_role_server.php');
			include(DIR_FSROOT.'/html/config/role_server/d_role_server.php');
			
			if (isset($_GET['f_id_config_server'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_server').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_server'])) {
				echo '<legend>Supprimer</legend>';
			}
			else {
				echo '<legend>Nouveau</legend>';
			}
			include(DIR_FSROOT.'/html/config/role_server/f_role_server.php');
			echo '</fieldset>';
		}
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';
	} else if ($component=='environment') {
		echo '<h1>Gestion des Environnements</h1>';
		include(DIR_FSROOT.'/html/config/environment/w_environment.php');
		include(DIR_FSROOT.'/html/config/environment/e_environment.php');
		include(DIR_FSROOT.'/html/config/environment/r_environment_wh_id.php');
		include(DIR_FSROOT.'/html/config/environment/r_environment.php');
		include(DIR_FSROOT.'/html/config/environment/d_environment.php');
		
		if (isset($_GET['f_id_config_environment'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_environment').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_environment)) {
			echo '<legend>'.$cur_environment->environment_description.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_config_environment'])) {
			echo '<legend>Modifier</legend>';
		}
		else {
			echo '<legend>Ajouter</legend>';
		}
		include(DIR_FSROOT.'/html/config/environment/f_environment.php');
		echo '</fieldset>';
		if (isset($_GET['f_id_config_environment'])) {
			echo '<fieldset>';
			echo '<legend>Environnements</legend>';
			include(DIR_FSROOT.'/html/config/environment_server/w_environment_server.php');
			include(DIR_FSROOT.'/html/config/environment_server/e_environment_server.php');
			include(DIR_FSROOT.'/html/config/environment_server/r_environment_server_wh_id.php');
			include(DIR_FSROOT.'/html/config/environment_server/r_environment_server.php');
			include(DIR_FSROOT.'/html/config/environment_server/d_environment_server.php');
			
			if (isset($_GET['f_id_config_server'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_server').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_server'])) {
				echo '<legend>Supprimer</legend>';
			}
			else {
				echo '<legend>Nouveau</legend>';
			}
			include(DIR_FSROOT.'/html/config/environment_server/f_environment_server.php');
			echo '</fieldset>';
		}
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';
	} else if ($component=='plugin') {
		echo '<h1>Gestion des plugins</h1>';
		include(DIR_FSROOT.'/html/config/plugin_filter/w_plugin_filter.php');
		include(DIR_FSROOT.'/html/config/plugin_filter/e_plugin_filter.php');
		include(DIR_FSROOT.'/html/config/plugin_filter/r_plugin_filter_wh_id.php');
		include(DIR_FSROOT.'/html/config/plugin_filter/r_plugin_filter.php');
		include(DIR_FSROOT.'/html/config/plugin_filter/d_plugin_filter.php');
		
		if (isset($_GET['f_id_config_plugin_filter'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_plugin_filter').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_plugin_filter)) {
			echo '<legend>'.$cur_plugin_filter->plugin_filter_desc.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_config_plugin_filter'])) {
			echo '<legend>Editer</legend>';
		}
		else {
			echo '<legend>Nouveau</legend>';
		}
		include(DIR_FSROOT.'/html/config/plugin_filter/f_plugin_filter.php');
		echo '</fieldset>';
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';
	}
} else if ($module=='auth') {
	if ($component=='user') {
		echo '<h1>Gestion des utilisateurs</h1>';
		include(DIR_FSROOT.'/html/auth/user/w_user.php');
		include(DIR_FSROOT.'/html/auth/user/e_user.php');
		include(DIR_FSROOT.'/html/auth/user/r_user_wh_id.php');
		include(DIR_FSROOT.'/html/auth/user/r_user.php');
		include(DIR_FSROOT.'/html/auth/user/d_user.php');
		
		if (isset($_GET['f_id_auth_user'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_user').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_user)) {
			echo '<legend>'.$cur_user->user.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_auth_user'])) {
			echo '<legend>Editer</legend>';
		}
		else {
			echo '<legend>Nouveau</legend>';
		}
		include(DIR_FSROOT.'/html/auth/user/f_user.php');
		echo '</fieldset>';
		
		if (isset($_GET['f_id_auth_user'])) {
			echo '<fieldset>';
			echo '<legend>Groupes</legend>';
			include(DIR_FSROOT.'/html/auth/user_group/w_user_group.php');
			include(DIR_FSROOT.'/html/auth/user_group/e_user_group.php');
			include(DIR_FSROOT.'/html/auth/user_group/r_user_group_wh_id.php');
			include(DIR_FSROOT.'/html/auth/user_group/r_user_group.php');
			include(DIR_FSROOT.'/html/auth/user_group/d_user_group.php');
			
			if (isset($_GET['f_id_auth_group'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_group').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_auth_group'])) {
				echo '<legend>Supprimer</legend>';
			}
			else {
				echo '<legend>Nouveau</legend>';
			}
			include(DIR_FSROOT.'/html/auth/user_group/f_user_group.php');
			echo '</fieldset>';
		}		
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';		
	}
	else if ($component=='group') {
		echo '<h1>Gestion des groupes</h1>';
		include(DIR_FSROOT.'/html/auth/group/w_group.php');
		include(DIR_FSROOT.'/html/auth/group/e_group.php');
		include(DIR_FSROOT.'/html/auth/group/r_group_wh_id.php');
		include(DIR_FSROOT.'/html/auth/group/r_group.php');
		include(DIR_FSROOT.'/html/auth/group/d_group.php');
		
		if (isset($_GET['f_id_auth_group'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_group').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_group)) {
			echo '<legend>'.$cur_group->group.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_auth_group'])) {
			echo '<legend>Editer</legend>';
		}
		else {
			echo '<legend>Nouveau</legend>';
		}
		include(DIR_FSROOT.'/html/auth/group/f_group.php');
		echo '</fieldset>';
		
		if (isset($_GET['f_id_auth_group'])) {
			echo '<fieldset>';
			echo '<legend>Utilisateurs</legend>';
			include(DIR_FSROOT.'/html/auth/group_user/w_group_user.php');
			include(DIR_FSROOT.'/html/auth/group_user/e_group_user.php');
			include(DIR_FSROOT.'/html/auth/group_user/r_group_user_wh_id.php');
			include(DIR_FSROOT.'/html/auth/group_user/r_group_user.php');
			include(DIR_FSROOT.'/html/auth/group_user/d_group_user.php');
			
			if (isset($_GET['f_id_auth_user'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_user').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_auth_user'])) {
				echo '<strong>Supprimer</strong>';
			}
			else {
				echo '<strong>Nouveau</strong>';
			}
			include(DIR_FSROOT.'/html/auth/group_user/f_group_user.php');
			echo '</fieldset>';
		}
		
		if (isset($_GET['f_id_auth_group'])) {
			echo '<fieldset>';
			echo '<legend>Projets</legend>';
			include(DIR_FSROOT.'/html/perm/group_project/w_group_project.php');
			include(DIR_FSROOT.'/html/perm/group_project/e_group_project.php');
			include(DIR_FSROOT.'/html/perm/group_project/r_group_project_wh_id.php');
			include(DIR_FSROOT.'/html/perm/group_project/r_group_project.php');
			include(DIR_FSROOT.'/html/perm/group_project/d_group_project.php');
			
			if (isset($_GET['f_id_config_project'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_project').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_project'])) {
				echo '<strong>Supprimer</strong>';
			}
			else {
				echo '<strong>Nouveau</strong>';
			}
			include(DIR_FSROOT.'/html/perm/group_project/f_group_project.php');
			echo '</fieldset>';		
		}
		
		if (isset($_GET['f_id_auth_group'])) {
			echo '<fieldset>';
			echo '<legend>Filtres Plugins</legend>';
			include(DIR_FSROOT.'/html/config/group_plugin_filter/w_group_plugin_filter.php');
			include(DIR_FSROOT.'/html/config/group_plugin_filter/e_group_plugin_filter.php');
			include(DIR_FSROOT.'/html/config/group_plugin_filter/r_group_plugin_filter_wh_id.php');
			include(DIR_FSROOT.'/html/config/group_plugin_filter/r_group_plugin_filter.php');
			include(DIR_FSROOT.'/html/config/group_plugin_filter/d_group_plugin_filter.php');
			
			if (isset($_GET['f_id_config_plugin_filter'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_config_plugin_filter').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_config_plugin_filter'])) {
				echo '<strong>Suppression</strong>';
			}
			else {
				echo '<strong>Nouveau</strong>';
			}
			include(DIR_FSROOT.'/html/config/group_plugin_filter/f_group_plugin_filter.php');
			echo '</fieldset>';
		}
		
		if (isset($_GET['f_id_auth_group'])) {
			echo '<fieldset>';
			echo '<legend>Autorisation d\'accès</legend>';
			include(DIR_FSROOT.'/html/perm/group_module/w_group_module.php');
			include(DIR_FSROOT.'/html/perm/group_module/e_group_module.php');
			include(DIR_FSROOT.'/html/perm/group_module/r_group_module_wh_id.php');
			include(DIR_FSROOT.'/html/perm/group_module/r_group_module.php');
			include(DIR_FSROOT.'/html/perm/group_module/d_group_module.php');
			
			if (isset($_GET['f_id_perm_module'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_perm_module').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_perm_module'])) {
				echo '<strong>Suppression</strong>';
			}
			else {
				echo '<strong>Nouveau</strong>';
			}
			include(DIR_FSROOT.'/html/perm/group_module/f_group_module.php');
			echo '</fieldset>';
		}
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';
	}
} else if ($module=='perm') {
	if ($component=='module') {
		echo '<h1>Gestion des Modules</h1>';
		include(DIR_FSROOT.'/html/perm/module/w_module.php');
		include(DIR_FSROOT.'/html/perm/module/e_module.php');
		include(DIR_FSROOT.'/html/perm/module/r_module_wh_id.php');
		include(DIR_FSROOT.'/html/perm/module/r_module.php');
		include(DIR_FSROOT.'/html/perm/module/d_module.php');
		
		if (isset($_GET['f_id_perm_module'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_perm_module').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		echo '<fieldset>';
		if (isset($cur_module)) {
			echo '<legend>'.$cur_module->module.' '.$cur_module->component.'</legend>';
		}
		echo '<fieldset>';
		if (isset($_GET['f_id_perm_module'])) {
			echo '<legend>Editer</legend>';
		}
		else {
			echo '<legend>Nouveau</legend>';
		}
		include(DIR_FSROOT.'/html/perm/module/f_module.php');
		echo '</fieldset>';
		
		if (isset($_GET['f_id_perm_module'])) {
			echo '<fieldset>';
			echo '<legend>Autorisation d\'accès</legend>';
			include(DIR_FSROOT.'/html/perm/module_group/w_module_group.php');
			include(DIR_FSROOT.'/html/perm/module_group/e_module_group.php');
			include(DIR_FSROOT.'/html/perm/module_group/r_module_group_wh_id.php');
			include(DIR_FSROOT.'/html/perm/module_group/r_module_group.php');
			include(DIR_FSROOT.'/html/perm/module_group/d_module_group.php');
			
			if (isset($_GET['f_id_auth_group'])) {
				echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_group').'">Nouveau</a> ]';
			}
			echo '<div class="spacer">&nbsp;</div>';
			if (isset($_GET['f_id_auth_group'])) {
				echo '<strong>Supprimer</strong>';
			}
			else {
				echo '<strong>Nouveau</strong>';
			}
			include(DIR_FSROOT.'/html/perm/module_group/f_module_group.php');
			echo '</fieldset>';
		}
		echo '</fieldset>';
		echo '<div class="spacer">&nbsp;</div>';	
	} 
} else if ($module=='dashboard') {
	if ($component=='view') {
		include(DIR_FSROOT.'/html/menu/menu_project.php');
		if (isset($_GET['f_id_config_server'])) {
			include(DIR_FSROOT.'/modules/preg_find.php');
			include(DIR_FSROOT.'/html/config/server/r_server_wh_id.php');
			include(DIR_FSROOT.'/html/dashboard/server_plugins/d_server_plugins.php');			
		}
	} else if ($component=='compare') {
		include(DIR_FSROOT.'/html/dashboard/server_compare/r_server.php');
		include(DIR_FSROOT.'/html/dashboard/server_compare/f_server.php');
	} else if ($component=='static_exploit') {
		include(DIR_FSROOT.'/html/dashboard/static/static_exploit.php');
	}
} else if ($module=='small_admin') {
	if ($component=='mygroup') {
		echo '<h1>Gérer mes groupes</h1>';
		include(DIR_FSROOT.'/html/small_admin/mygroup/w_group.php');
		include(DIR_FSROOT.'/html/small_admin/mygroup/r_group_wh_id.php');
		include(DIR_FSROOT.'/html/small_admin/mygroup/r_group.php');
		include(DIR_FSROOT.'/html/small_admin/mygroup/d_group.php');
		
		if (isset($_GET['f_id_auth_group'])) {
			echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_group').'">Nouveau</a> ]';
		}
		echo '<div class="spacer">&nbsp;</div>';
		$perm_grp = new PERMS();
		$f_id_auth_group=intval($_GET['f_id_auth_group']);
		if (($f_id_auth_group && $perm_grp->auth_user_group($_SESSION['S_ID_USER'],$f_id_auth_group,true)) || !$f_id_auth_group) {
			echo '<fieldset>';
			if (isset($cur_group)) {
				echo '<legend>'.$cur_group->group.'</legend>';
			}
			echo '<fieldset>';
			if (isset($_GET['f_id_auth_group'])) {
				echo '<legend>Editer</legend>';
			}
			else {
				echo '<legend>Nouveau</legend>';
			}
		
			include(DIR_FSROOT.'/html/small_admin/mygroup/f_group.php');
			echo '</fieldset>';
			
			if (isset($_GET['f_id_auth_group'])) {
				echo '<fieldset>';
				echo '<legend>Utilisateurs</legend>';
				include(DIR_FSROOT.'/html/small_admin/mygroup_user/w_group_user.php');
				include(DIR_FSROOT.'/html/small_admin/mygroup_user/e_group_user.php');
				include(DIR_FSROOT.'/html/small_admin/mygroup_user/r_group_user_wh_id.php');
				include(DIR_FSROOT.'/html/small_admin/mygroup_user/r_group_user.php');
				include(DIR_FSROOT.'/html/small_admin/mygroup_user/d_group_user.php');
				
				if (isset($_GET['f_id_auth_user'])) {
					echo '[ <a href="'.removeqsvar($cur_url,'f_id_auth_user').'">Nouveau</a> ]';
				}
				echo '<div class="spacer">&nbsp;</div>';
				if (isset($_GET['f_id_auth_user'])) {
					echo '<strong>Supprimer</strong>';
				}
				else {
					echo '<strong>Nouveau</strong>';
				}
				include(DIR_FSROOT.'/html/small_admin/mygroup_user/f_group_user.php');
				echo '</fieldset>';
			}
			echo '</fieldset>';
		}
		echo '<div class="spacer">&nbsp;</div>';
	} else if ($component=='myaccount') {
		echo '<h1>Mon Compte</h1>';
		include(DIR_FSROOT.'/html/small_admin/myaccount/w_myaccount.php');
		include(DIR_FSROOT.'/html/small_admin/myaccount/r_myaccount_wh_id.php');
		include(DIR_FSROOT.'/html/small_admin/myaccount/f_myaccount.php');
	} else if ($component=='newuser') {
		echo '<h1>Créer un Compte</h1>';
		include(DIR_FSROOT.'/html/small_admin/newuser/w_user.php');
		include(DIR_FSROOT.'/html/small_admin/newuser/f_user.php');
	}
}

} // FIN PERM MODULE
else {
	if ($component && $module) {
		echo '<br />Vous n\'avez pas accès à cette partie du site<br />';
	} else {
		echo $CONFIG['welcome_text'];
	}
}
?>