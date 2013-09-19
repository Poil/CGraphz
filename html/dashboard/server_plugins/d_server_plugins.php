<?php
$f_id_config_project=intval($_GET['f_id_config_project']);

if (isset($_GET['f_id_config_server'])) {
	include(DIR_FSROOT.'/html/menu/time_selector.php');
}

if (NEW_MENU) {
	echo '<div id="dashboard" style="margin-left:100pt;">';
} else {
	echo '<div id="dashboard">';
}
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
				$pc=null;
				if (substr_count($pi, '-') >= 1) {
					$tmp=explode('-',$pi);
					// Fix when PI is null after separating PC/PI for example a directory named "MyHost/GenericJMX-cassandra_activity_request-/"
					if (strlen($tmp[1])) {
						$pc=$tmp[0];
						$pi=implode('-', array_slice($tmp,1));
					}
				}
			} else { 
				$pc=null; 
				$pi=null; 
			}
			if (isset($matches[4])) {
				$t=$matches[4];
			} else { 
				$t=null; 
			}
			if (isset($matches[5])) {
				$ti=$matches[5];
				$tc=null;
				if (substr_count($ti, '-') >= 1 && preg_match($CONFIG['plugin_tcategory'], $p)) {
					$tmp=explode('-',$ti);
					$tc=$tmp[0];
					//$ti=implode('-', array_slice($tmp,1));
					$ti=null;
				}
			} else { 
				$tc=null; 
				$ti=null; 
			}


			if (!isset(${$p.$pc.$pi.$t.$tc.$ti}) ) {
				if ($$p!=true) {
					$lvl_p=2;
					$lvl_pc=$lvl_p+1;
					$lvl_pi=$lvl_pc;
					$lvl_tc=null;
					echo "<h$lvl_p>".ucfirst($p)."</h$lvl_p>";
					$$p=true;
					$others=false;
				}
				// Displaying Plugin Category if there is a Plugin Category
				if ($pc!=null && $$pc!=true) {
					echo "<h$lvl_pc>".ucfirst(str_replace('_', ' ', $pc))."</h$lvl_pc>";
					$lvl_pi=$lvl_pc+1;
					$$pc=true;
					$others=false;
					// Displaying a Fake Plugin Category if we had a plugin category for others PI
				} else if ($old_pc!=null && $pc==null && $p==$old_p && $others==false) {
					$lvl_pi=$lvl_pc;
					$others=true;
					echo "<h$lvl_pc>".ucfirst(str_replace('_', ' ', $pi))."</h$lvl_pc>";
				} 
				// Displaying Plugin Instance for some plugins
				if (preg_match($CONFIG['title_pinstance'],$p) && strlen($pi) && $$pi!=true) {
					$$pi=true;
					echo "<h$lvl_pi>".ucfirst(str_replace('_', ' ',$pi))."</h$lvl_pi>";
				}

				${$p.$pc.$pi.$t.$tc.$ti}=true;

				// Verif regex OK
				if ($p!=null && $t!=null) {
					if (!preg_match('/^(df|interface|oracle)$/', $p) || $CONFIG['version'] >= 5) {
						$ti='';
						if ($old_t!=$t or $old_pi!=$pi or $old_pc!=$pc or $old_tc!=$tc)   {
							if ($CONFIG['graph_type'] == 'canvas') {
								$_GET['h'] = $cur_server->server_name;
								$_GET['p'] = $p;
								$_GET['pc'] = $pc;
								$_GET['pi'] = $pi;
								$_GET['t'] = $t;
								$_GET['tc'] = $tc;
								$_GET['ti'] = $ti;

								chdir(DIR_FSROOT);
								include DIR_FSROOT.'/plugin/'.$p.'.php';
							} else {
								if ($time_range!='') {
									echo '<img class="imggraph" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pc='.$pc.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;tc='.$tc.'&amp;ti='.$ti.'&amp;s='.$time_range.'" />'."\n";
								} else {
									echo '<img class="imggraph" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pc='.$pc.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;tc='.$tc.'&amp;ti='.$ti.'&amp;s='.$time_start.'&amp;e='.$time_end.'" />'."\n";
								}
							}
							if (isset($time_start) && isset($time_end)) {
								echo '<img class="imgzoom" style="cursor:pointer" onclick="Show_Popup($(this).prev(\'img\').attr(\'src\').split(\'?\')[1],\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
							} else {
								echo '<img class="imgzoom" style="cursor:pointer" onclick="Show_Popup($(this).prev(\'img\').attr(\'src\').split(\'?\')[1],\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
							}
							//$cpt++;
						}
					} else {
						if ($CONFIG['graph_type'] == 'canvas') {
							$_GET['h'] = $cur_server->server_name;
							$_GET['p'] = $p;
							$_GET['pc'] = $pc;
							$_GET['pi'] = $pi;
							$_GET['t'] = $t;
							$_GET['tc'] = $tc;
							$_GET['ti'] = $ti;

							chdir(DIR_FSROOT);
							include DIR_FSROOT.'/plugin/'.$p.'.php';
						} else {
							if ($time_range!='') {
								echo '<img class="imggraph" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pc='.$pc.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;tc='.$tc.'&amp;ti='.$ti.'&amp;s='.$time_range.'" />'."\n";
							} else {
								echo '<img class="imggraph" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.'&amp;p='.$p.'&amp;pc='.$pc.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;tc='.$tc.'&amp;ti='.$ti.'&amp;s='.$time_start.'&amp;e='.$time_end.'" />'."\n";
							}
						}
						if (isset($time_start) && isset($time_end)) {
							echo '<img class="imgzoom" style="cursor:pointer" onclick="Show_Popup($(this).prev(\'img\').attr(\'src\').split(\'?\')[1],\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
						} else {
							echo '<img class="imgzoom" style="cursor:pointer" onclick="Show_Popup($(this).prev(\'img\').attr(\'src\').split(\'?\')[1],\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
						}
						//$cpt++;
					}
				} else if (DEBUG==true){
					echo 'ERREUR - p='.$p.' pc='.$pc.' pi='.$pi.' t='.$t.' tc='.$tc.' ti='.$ti.'<br />';
				} 
			} 
			$old_t=$t;
			$old_tc=$tc;
			$old_p=$p;
			$old_pi=$pi;
			$old_pc=$pc;
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
				if ($t!=$old_t) echo '<h4>'.ucfirst(str_replace('_', ' ',$t)).'</h4>';
				$old_t=$t;

				echo '<img class="imggraph" src='.DIR_WEBROOT.'/graph.php?h='.$cur_server->server_name.':'.$vm.'&amp;p='.$p.'&amp;pc='.$pc.'&amp;pi='.$pi.'&amp;t='.$t.'&amp;tc='.$tc.'&amp;ti='.$ti.'&amp;s='.$time_range.' />';
				if (isset($time_start) && isset($time_end)) {
					echo '<img class="imgzoom" style="cursor:pointer" onclick="Show_Popup($(this).prev(\'img\').attr(\'src\').split(\'?\')[1],\'\',\''.$time_start.'\',\''.$time_end.'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
				} else {
					echo '<img class="imgzoom" style="cursor:pointer" onclick="Show_Popup($(this).prev(\'img\').attr(\'src\').split(\'?\')[1],\''.$time_range.'\',\'\',\'\')" src="img/zoom.png" title="Zoom" alt="=O" />'."\n";
				}
			}
		}
	}
}
echo '</div>';
echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/CGP.js"></script>';
?>
