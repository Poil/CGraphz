<?php
if (isset($_GET['auto_refresh'])) {
	$urlrefresh='<a href="'.removeqsvar($_SERVER['REQUEST_URI'],'auto_refresh').'"><img src="img/auto_refresh_on.png" title="'.STOP_AUTO_REFRESH.'" alt="Auto Refresh" /></a>';
} else {
	$urlrefresh='<a href="'.htmlentities($_SERVER['REQUEST_URI']).'&amp;auto_refresh=true"><img src="img/auto_refresh.png" title="'.ENABLE_AUTO_REFRESH.'" alt="Auto Refresh" /></a>';
}

if (isset($_GET['f_id_config_server'])) {
	echo '
	<div id="left_menu">
		<div id="left_menu_show">
			<ul>			
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'3600\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'7200\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">2h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'21600\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">6h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'43200\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">12h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'86400\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.DAY.'</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'172800\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">2 '.DAYS.'</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'604800\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.WEEK.'</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'2592000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.MONTH.'</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'15552000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">6 '.MONTHS.'</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'31104000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.YEAR.'</a></li>
				<li><a href="#" onclick="Show_Popup($(\'.imggraph:first\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\'); $(\'#left_menu_show\').hide(\'400\'); return false">'.CUSTOM.'</a></li>
			</ul>
		</div>
		<img src="img/refresh.png" style="cursor:pointer" onclick="refresh_graph(\'dashboard\',\'\',\'\',\'\'); return false" title="'.REFRESH.'" alt="Refresh" />
		<br />
		<img src="img/clock.png" style="cursor:pointer" onclick="$(\'#left_menu_show\').toggle(\'400\'); return false;" title="'.TIME_SELECTOR.'" alt="Time Selector" />
		<br />
		'.$urlrefresh.'
	</div>';
}

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
