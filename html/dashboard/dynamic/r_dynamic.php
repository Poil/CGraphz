<?php
$f_id_config_dynamic_dashboard=intval($_GET['f_id_config_dynamic_dashboard']);

if (isset($_SESSION['time_range']) && is_numeric($_SESSION['time_range'])) {
	$time_range=$_SESSION['time_range'];
} else {
	if (isset($_SESSION['time_start']) && is_numeric($_SESSION['time_start']) && isset($_SESSION['time_end']) && is_numeric($_SESSION['time_end'])) {
		$time_start=$_SESSION['time_start'];
		$time_end=$_SESSION['time_end'];
		$time_range='';
	} else {
		$time_range=$CONFIG['time_range']['default'];
		$time_start='';
		$time_end='';
	}
}

if (isset($_GET['auto_refresh'])) {
	$urlrefresh='<a href="'.removeqsvar($_SERVER['REQUEST_URI'],'auto_refresh').'"><img src="img/auto_refresh_on.png" title="Arrêter l\'Auto refresh" alt="Auto Refresh" /></a>';
} else {
	$urlrefresh='<a href="'.htmlentities($_SERVER['REQUEST_URI']).'&amp;auto_refresh=true"><img src="img/auto_refresh.png" title="Activer l\'Auto Refresh" alt="Auto Refresh" /></a>';
}

if (isset($_GET['f_id_config_dynamic_dashboard'])) {
	echo '
	<div id="left_menu">
		<div id="left_menu_show">
			<ul>			
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'3600\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'7200\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">2h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'21600\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">6h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'43200\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">12h</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'86400\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 jour</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'172800\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">2 jours</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'604800\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 semaine</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'2592000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 mois</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'15552000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">6 mois</a></li>
				<li><a href="#" onclick="refresh_graph(\'dashboard\',\'31104000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 an</a></li>
				<li><a href="#" onclick="Show_Popup($(\'.imggraph:first\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')">Custom</a></li>
			</ul>
		</div>
		<img src="img/refresh.png" style="cursor:pointer" onclick="refresh_graph(\'dashboard\',\'\',\'\',\'\'); return false" title="Rafraichir" alt="Refresh" />
		<br />
		<img src="img/clock.png" style="cursor:pointer" onclick="$(\'#left_menu_show\').toggle(\'400\'); return false;" title="Echelle de temps" alt="Time Selector" />
		<br />
		'.$urlrefresh.'
	</div>';
}


echo '<div id="dashboard">';

if ($_GET['f_id_config_dynamic_dashboard']) {

	$connSQL=new DB();
	
	$lib='SELECT 
			cddg.* 
		FROM 
			config_dynamic_dashboard cdd
		LEFT JOIN config_dynamic_dashboard_group cddg
			ON cdd.id_config_dynamic_dashboard=cddg.id_config_dynamic_dashboard
		LEFT JOIN config_dynamic_dashboard_content cddc
			ON cdd.id_config_dynamic_dashboard=cddc.id_config_dynamic_dashboard
		LEFT JOIN auth_user_group aug
			ON cddg.id_auth_group=aug.id_auth_group
		LEFT JOIN auth_user au
			ON aug.id_auth_user=au.id_auth_user
		WHERE aug.id_auth_user='.intval($_SESSION['S_ID_USER']).'
		AND cdd.id_config_dynamic_dashboard='.$f_id_config_dynamic_dashboard.'
		ORDER BY dash_ordering';
		
	$cur_dashboard=$connSQL->getRow($lib);
	//$final_array = array();
	
	if ($cur_dashboard->id_auth_group) {
		$lib='SELECT
				cddc.*
			FROM
				config_dynamic_dashboard_content cddc
			WHERE
				cddc.id_config_dynamic_dashboard='.$f_id_config_dynamic_dashboard.'
			ORDER BY dash_ordering';
				
			$all_content=$connSQL->getResults($lib);
			$cpt_content=count($all_content);
			
		
		for ($i=0; $i<$cpt_content; $i++) {
			$cpt_p=0;
			
			$lib='
				SELECT 
					cs.id_config_server, 
					cs.server_name 
				FROM config_server cs
					LEFT JOIN config_server_project csp 
						ON cs.id_config_server=csp.id_config_server
					LEFT JOIN perm_project_group ppg 
						ON ppg.id_config_project=csp.id_config_project
					LEFT JOIN auth_group ag 
						ON ag.id_auth_group=ppg.id_auth_group
					LEFT JOIN auth_user_group aug 
						ON aug.id_auth_group=ag.id_auth_group
				WHERE aug.id_auth_user='.intval($_SESSION['S_ID_USER']).'
					AND cs.server_name REGEXP "'.$all_content[$i]->regex_srv.'"
				GROUP BY id_config_server, server_name
				ORDER BY server_name';

			$all_server=$connSQL->getResults($lib);
			$cpt_server=count($all_server);			
			
			for ($j=0; $j<$cpt_server; $j++) {
				
				if (is_dir($CONFIG['datadir'].'/'.$all_server[$j]->server_name.'/')) {
					$myregex='#^('.$CONFIG['datadir'].'/'.$all_server[$j]->server_name.'/)('.$all_content[$i]->regex_p_filter.')(?:\-('.$all_content[$i]->regex_pi_filter.'))?/('.$all_content[$i]->regex_t_filter.')(?:\-('.$all_content[$i]->regex_ti_filter.'))?\.rrd#';

					$plugins = preg_find($myregex, $CONFIG['datadir'].'/'.$all_server[$j]->server_name, PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH|PREG_FIND_SORTBASENAME);
					
					foreach ($plugins as $plugin) {
						$plugin_array[$cpt_p]['servername']=$all_server[$j]->server_name;

						preg_match($myregex, $plugin, $matches);
						
						if (isset($matches[2])) {
							$plugin_array[$cpt_p]['p']=$matches[2];
						} else {
							$plugin_array[$cpt_p]['p']='';
						}
						if (isset($matches[3]) && $matches[3]!='') {
							$plugin_array[$cpt_p]['pi']=$matches[3];
						} else {
							$plugin_array[$cpt_p]['pi']='';
						}						
						if (isset($matches[4])) {
							$plugin_array[$cpt_p]['t']=$matches[4];
						} else {
							$plugin_array[$cpt_p]['t']='';
						}						
						if (isset($matches[5]) && $matches[5]!='') {
							$plugin_array[$cpt_p]['ti']=$matches[5];
						} else {
							$plugin_array[$cpt_p]['ti']='';
						}
						
						$cpt_p++;
					}
				}
			}

			if ($all_content[$i]->rrd_ordering=='S') {
				$plugin_array = sortArray($plugin_array, array('servername', 'p','pi','t','ti'));
			} else if ($all_content[$i]->rrd_ordering=='P') {
				$plugin_array = sortArray($plugin_array, array('p','servername','pi','t','ti'));
			} else if ($all_content[$i]->rrd_ordering=='PI') {
				$plugin_array = sortArray($plugin_array, array('pi', 'p','servername', 't','ti'));
			} else if ($all_content[$i]->rrd_ordering=='T') {
				$plugin_array = sortArray($plugin_array, array('t','servername', 'p','pi','ti'));
			} else if ($all_content[$i]->rrd_ordering=='TI') {
				$plugin_array = sortArray($plugin_array, array('ti','servername', 'p','pi','t'));
			}

			$old_t='';
			$old_ti='';
			$old_pi='';
			$old_p='';
			$old_servername='';
			
			//$final_array=array_merge_recursive($plugin_array, $final_array);
			foreach ($plugin_array as $plugin) {
				if (preg_match('/^GenericJMX|elasticsearch/', $plugin['p'])) {
					if (substr_count($plugin['ti'], '-') >= 1) {
						if ($plugin['ti']!='') {
							$tmp=explode('-',$plugin['ti']);
							$plugin['ti']=$tmp[0];
							if ($plugin['ti']!='') $plugin['ti']=$plugin['ti'].'-*';
						}
					} else {
						$plugin['ti']='';
					}
				}
				
				if (! isset(${$plugin['servername'].$plugin['p'].$plugin['pi'].$plugin['t'].$plugin['ti']}) ) {
					${$plugin['servername'].$plugin['p'].$plugin['pi'].$plugin['t'].$plugin['ti']}=true;
					
					if ($all_content[$i]->rrd_ordering=='S') {
						
						if ($old_servername!=$plugin['servername']) {
							echo '<h1>'.$plugin['servername'].'</h1>';
							$old_p='';
						}
						if ($old_p!=$plugin['p']) {
							echo '<h2>'.$plugin['p'].'</h2>';
						}

					} else if ($all_content[$i]->rrd_ordering=='P') {
						if ($old_p!=$plugin['p']) {
							echo '<h1>'.$plugin['p'].'</h1>';
						}
					} else if ($all_content[$i]->rrd_ordering=='PI') {
						if ($old_pi!=$plugin['pi']) {
							echo '<h1>'.$plugin['p'].' '.$plugin['pi'].'</h1>';
						} else if (!$plugin['pi'] && $old_p!=$plugin['p']) {
							echo '<h1>'.$plugin['p'].'</h1>';
						}
					} else if ($all_content[$i]->rrd_ordering=='T') {
						if ($old_t!=$plugin['t']) {
							echo '<h1>'.$plugin['t'].'</h1>';
						}
					} else if ($all_content[$i]->rrd_ordering=='TI') {
						if ($old_ti!=$plugin['ti']) {
							echo '<h1>'.$plugin['ti'].'</h1>';
						} else if (!$plugin['ti'] && $old_t!=$plugin['t']) {
							echo '<h1>'.$plugin['t'].'</h1>';
						}
					}
				
					if (preg_match('/^GenericJMX|elasticsearch/', $plugin['p'])) {
						if ($old_t!=$plugin['t'] or $old_pi!=$plugin['pi'] or ($ti!="" && $old_ti!=$plugin['ti'])) {
						    $tmp=explode('-',$plugin['pi']);
							if ($time_range!='') {
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$plugin['servername'].'&amp;p='.$plugin['p'].'&amp;pi='.$plugin['pi'].'&amp;t='.$plugin['t'].'&amp;ti='.$plugin['ti'].'&amp;s='.$time_range.' />';
							} else {
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$plugin['servername'].'&amp;p='.$plugin['p'].'&amp;pi='.$plugin['pi'].'&amp;t='.$plugin['t'].'&amp;ti='.$plugin['ti'].'&amp;s='.$time_start.'&amp;e='.$time_end.' />';
							}
							if (isset($time_start) && isset($time_end)) {
							        echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
							} else {
							        echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
						        }
						        $old_subpg=$subpg;
						}
					} else if (!preg_match('/^(df|interface|oracle)$/', $plugin['p'])) {
						$plugin['ti']='';
						if ($old_t!=$plugin['t'] or $old_pi!=$plugin['pi'] or $plugin['servername']!=$old_servername)	{
							if ($time_range!='') {
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$plugin['servername'].'&amp;p='.$plugin['p'].'&amp;pi='.$plugin['pi'].'&amp;t='.$plugin['t'].'&amp;ti='.$plugin['ti'].'&amp;s='.$time_range.' />'."\n";
							} else {
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$plugin['servername'].'&amp;p='.$plugin['p'].'&amp;pi='.$plugin['pi'].'&amp;t='.$plugin['t'].'&amp;ti='.$plugin['ti'].'&amp;s='.$time_start.'&amp;e='.$time_end.' />'."\n";
							}
							if (isset($time_start) && isset($time_end)) {
								echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
							} else {
								echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
							}
						}
					} else {
						if ($time_range!='') {
							echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$plugin['servername'].'&amp;p='.$plugin['p'].'&amp;pi='.$plugin['pi'].'&amp;t='.$plugin['t'].'&amp;ti='.$plugin['ti'].'&amp;s='.$time_range.' />'."\n";
						} else {
							echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$plugin['servername'].'&amp;p='.$plugin['p'].'&amp;pi='.$plugin['pi'].'&amp;t='.$plugin['t'].'&amp;ti='.$plugin['ti'].'&amp;s='.$time_start.'&amp;e='.$time_end.' />'."\n";
						}
						if (isset($time_start) && isset($time_end)) {
							echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
						} else {
							echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
						}
					}
			
					$old_t=$plugin['t'];
					$old_ti=$plugin['ti'];
					$old_pi=$plugin['pi'];
					$old_p=$plugin['p'];
					$old_servername=$plugin['servername'];
				}
			}
		}
	}
}



echo '</div>';

function sortArray($data, $field) {
	if(!is_array($field)) $field = array($field); 
	usort($data, function($a, $b) use($field) {
		 $retval = 0; 
		 foreach($field as $fieldname) {
		 	 if($retval == 0) $retval = strnatcmp($a[$fieldname],$b[$fieldname]); 
		 } 
		 return $retval; 
	}); 
	return $data; 
}
?>
