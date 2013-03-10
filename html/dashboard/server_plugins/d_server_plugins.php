<?php
$f_id_config_project=intval($_GET['f_id_config_project']);



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

echo '<div id="dashboard">';

if ($cur_server->server_name=='') {
	echo '<h1>'.UNKNOWN_SERVER.'</h1>';
	echo '</div>';
	exit;
}

echo '<h1>'.$cur_server->server_name.'</h1>';

$lib = 'SELECT 
			cpf.*			
		FROM 
			config_plugin_filter cpf
			LEFT JOIN config_plugin_filter_group cpfg
				ON cpf.id_config_plugin_filter=cpfg.id_config_plugin_filter
			LEFT JOIN auth_group ag 
				ON cpfg.id_auth_group=ag.id_auth_group
			LEFT JOIN auth_user_group aug 
				ON aug.id_auth_group=ag.id_auth_group
			LEFT JOIN perm_project_group ppg 
				ON ppg.id_auth_group=ag.id_auth_group
		WHERE 
			aug.id_auth_user="'.$_SESSION['S_ID_USER'].'"
		AND ppg.id_config_project="'.$f_id_config_project.'"
		ORDER BY plugin_order, plugin, plugin_instance, type, type_instance';

$connSQL=new DB();
$pg_filters=$connSQL->getResults($lib);


if (is_dir($CONFIG['datadir']."/$cur_server->server_name/")) {
	foreach ($pg_filters as $filter) {
		$myregex='#^('.$CONFIG['datadir'].'/'.$cur_server->server_name.'/)('.$filter->plugin.')(?:\-('.$filter->plugin_instance.'))?/('.$filter->type.')(?:\-('.$filter->type_instance.'))?\.rrd#';
		
		$plugins = preg_find($myregex, $CONFIG['datadir'].'/'.$cur_server->server_name, PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH|PREG_FIND_SORTBASENAME);
		
		$old_t='';
		$old_pi='';
		$old_subpg='';
		foreach ($plugins as $plugin) {
			preg_match($myregex, $plugin, $matches);

			if (isset($matches[2])) {
				$p=$matches[2];
				if (!isset($$p)) $$p=false;
			} else { 
				$p=null; 
			}
			if (isset($matches[3])) {
				$pi=$matches[3];
			} else { 
				$pi=null; 
			}
			if (isset($matches[4])) {
				$t=$matches[4];
			} else { 
				$t=null; 
			}
			if (isset($matches[5])) {
				$ti=$matches[5];
			} else { 
				$ti=null; 
			}

			
			if ($$p!=true) {
				echo "<h3>$p</h3>";
				$$p=true;
			}
			
			if (preg_match('/^GenericJMX|elasticsearch/', $p)) {
				if (substr_count($ti, '-') >= 1) {
					if ($ti!='') {
						$tmp=explode('-',$ti);
						$ti=$tmp[0];
					}
				} else {
					$ti='';
				}
			}
			if (! isset(${$p.$pi.$t.$ti}) ) {
				${$p.$pi.$t.$ti}=true;
				
				// Verif regex OK
				if ($p!="" && $t!="") {
					if (preg_match('/^GenericJMX|elasticsearch/', $p)) {

						if ($ti!='') $ti=$ti.'-*';
						if ($old_t!=$t or $old_pi!=$pi or ($ti!="" && $old_ti!=$ti)) {
						    $tmp=explode('-',$pi);
							$subpg=$tmp[0];
							if ($subpg!=$old_subpg) {
							        echo '<h4>'.str_replace("_", " ",$subpg).'</h4>';
							}
							
							if (substr_count($pi, '-') >= 1) {
								$tmp=explode('-',$pi);
								$subpi=$tmp[1];
								if ($subpi!=$old_subpi) {
									echo '<h5>'.str_replace("_", " ",$subpi).'</h5>';
									$old_subpi=$subpi;
								}
							}
							
							if ($time_range!='') {
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;ti='.$ti.'&amp;s='.$time_range.' />';
							} else {
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;ti='.$ti.'&amp;s='.$time_start.'&amp;e='.$time_end.' />';
							}
							if (isset($time_start) && isset($time_end)) {
							        echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
							} else {
							        echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
						        }
						        $old_subpg=$subpg;
						}
					} else if (!preg_match('/^(df|interface|oracle)$/', $p) || $CONFIG['version']) {
						$ti='';
						if ($old_t!=$t or $old_pi!=$pi)	{
							if ($time_range!='') {						
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;ti='.$ti.'&amp;s='.$time_range.' />';
							} else {
								echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;ti='.$ti.'&amp;s='.$time_start.'&amp;e='.$time_end.' />';
							}
							if (isset($time_start) && isset($time_end)) {
								echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
							} else {
								echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
							}
							//$cpt++;
						}
					} else {
						if ($time_range!='') {
							echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;ti='.$ti.'&amp;s='.$time_range.' />';
						} else {
							echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;ti='.$ti.'&amp;s='.$time_start.'&amp;e='.$time_end.' />';
						}
						if (isset($time_start) && isset($time_end)) {
							echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
						} else {
							echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
						}
						//$cpt++;
					}
					$old_t=$t;
					$old_pi=$pi;
				} else if (DEBUG==true){
					echo 'ERREUR - p='.$p.' pi='.$pi.' t='.$t.' ti='.$ti.'<br />';
				} 
			} 
		}
	}
}

/* VMHOST LibVirt */
$vmlist = preg_find('#^'.$cur_server->server_name.':#', $CONFIG['datadir'].'/', PREG_FIND_DIRMATCH|PREG_FIND_SORTBASENAME);

//print_r($vmlist);

foreach ($vmlist as $vmdir) {

	$tmp=explode(':',$vmdir);
	$vm=$tmp[1];
	//$$t=false;
	
	echo "<h3>$vm</h3>";
	
	foreach ($pg_filters as $filter) {
		$myregex='#^('.$vmdir.'/)('.$filter->plugin.')(?:\-('.$filter->plugin_instance.'))?/('.$filter->type.')(?:\-('.$filter->type_instance.'))?\.rrd#';
		
		$plugins = preg_find($myregex, $vmdir, PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH|PREG_FIND_SORTBASENAME);
		
		$old_t='';
		$old_pi='';
		foreach ($plugins as $plugin) {
			preg_match($myregex, $plugin, $matches);

			if (isset($matches[2])) {
				$p=$matches[2];
				if (!isset($$p)) $$p=false;
			} else { 
				$p=null; 
			}
			if (isset($matches[3])) {
				$pi=$matches[3];
			} else { 
				$pi=null; 
			}
			if (isset($matches[4])) {
				$t=$matches[4];
			} else { 
				$t=null; 
			}
			if (isset($matches[5])) {
				$ti=$matches[5];
			} else { 
				$ti=null; 
			}

			if (! isset(${$vm.$p.$pi.$t.$ti}) ) {
				${$vm.$p.$pi.$t.$ti}=true;
				if ($t!=$old_t) echo '<h4>'.$t.'</h4>';
				$old_t=$t;
				
				echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.':'.$vm.'&amp;p='.$p.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;ti='.$ti.'&amp;s='.$time_range.' />';
				if (isset($time_start) && isset($time_end)) {
					echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
				} else {
					echo '<img class="imgzoom" style="cursor:pointer" onClick="Show_Popup($(this).prev(\'img\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />';
				}
			}
		}
	}
}
echo '</div>';
?>
