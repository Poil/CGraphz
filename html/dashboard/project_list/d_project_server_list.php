<?php
/*
if (isset($_GET['auto_refresh'])) {
	$urlrefresh='<a href="'.removeqsvar($_SERVER['REQUEST_URI'],'auto_refresh').'"><img src="img/auto_refresh_on.png" title="'.STOP_AUTO_REFRESH.'" alt="Auto Refresh" /></a>';
} else {
	$urlrefresh='<a href="'.htmlentities($_SERVER['REQUEST_URI']).'&amp;auto_refresh=true"><img src="img/auto_refresh.png" title="'.ENABLE_AUTO_REFRESH.'" alt="Auto Refresh" /></a>';
}

if (isset($_GET['f_id_config_server'])) {
	include(DIR_FSROOT.'/html/menu/time_selector.php');
}
*/
if (isset($_GET['f_id_config_project'])) {
	if (isset($all_environment) && $cpt_environment>1) {
		echo '<div id="div_menu_server_environment">';
		foreach ($all_environment as $environment) {
			if (isset($_GET['f_id_config_environment']) && intval($_GET['f_id_config_environment'])==$environment->id_config_environment) { 
				$style=' style="font-weight: bold;" '; 
			} else { 
				$style=''; 
			}
			if (isset($environment->id_config_environment)) $myenvironment=$environment->id_config_environment;
			else $myenvironment=0;
			
			if (isset($myrole)) {
				echo '<span><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$myenvironment.'&amp;f_id_config_role='.$myrole.'">'.$environment->environment_description.'</a></span>';
			}
			else {
				echo '<span><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$myenvironment.'">'.$environment->environment_description.'</a></span>';
			}
		}	
		echo '<div class="spacer">&nbsp;</div>';
		echo '</div>';
	}
	if ($cpt_environment <= 1 || isset($_GET['f_id_config_environment'])) {
		if (isset($all_role) && $cpt_role>1) {
			echo '<div id="div_menu_server_role">';
			foreach ($all_role as $role) {
				if (isset($_GET['f_id_config_role']) && intval($_GET['f_id_config_role'])==$role->id_config_role) { 
					$style=' style="font-weight: bold;" '; 
				} else { 
					$style=''; 
				}
				if (isset($role->id_config_role)) $myrole=$role->id_config_role;
				else $myrole=0;
				
				if (isset($_GET['f_id_config_environment'])) {
					$f_id_config_environment=intval($_GET['f_id_config_environment']);
					echo '<span><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$f_id_config_environment.'&amp;f_id_config_role='.$myrole.'">'.$role->role_description.'</a></span>';
				}
				else {
					echo '<span><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_role='.$myrole.'">'.$role->role_description.'</a></span>';
				}			
			}	
			echo '<div class="spacer">&nbsp;</div>';
			echo '</div>';
		}
		if (($cpt_server<MAX_SRV || $cpt_role<=1 || isset($_GET['f_id_config_role'])) && $cpt_server!==0) {
			echo '<div id="div_menu_project_server">';
			foreach ($all_server as $server) {
				if (intval(GET('f_id_config_server'))==$server->id_config_server) { 
					$style=' style="font-weight: bold;" '; 
				} else { 
					$style=''; 
				}
				if (($cpt_server>MAX_SRV && $cpt_role>1) || isset($_GET['f_id_config_role'])) $str_role='&amp;f_id_config_role='.$f_id_config_role;
				else $str_role='';
				if (isset($_GET['f_id_config_environment'])) $str_environment='&amp;f_id_config_environment='.$f_id_config_environment;
				else $str_environment='';
				
				// if (isset($_GET['f_id_config_role']) && $_GET['f_id_config_role']!="") $str_role='&amp;f_id_config_role='.$_GET['f_id_config_role'];
				
				echo '<span><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.$str_role.$str_environment.'&amp;f_id_config_server='.$server->id_config_server.'">'.$server->server_name.'</a></span>';
			}
			echo '<div class="spacer">&nbsp;</div>';
			echo '</div>';
		}
	}
}

if (isset($_GET['auto_refresh'])) {
	echo '
	<script type="text/javascript">
	$(document).ready(function() {
	  var auto_refresh=setInterval(function() {
	     refresh_graph(\'dashboard\',\'\',\'\',\'\');
	  }, 60000)
	});
	</script>';
}
?>
