<?php
$f_host=filter_input(INPUT_GET,'f_host',FILTER_SANITIZE_STRING);
$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

$connSQL=new DB();

$lib='
	SELECT 
		cs.id_config_server, 
		cs.server_name,
		COALESCE(cs.collectd_version,"'.COLLECTD_DEFAULT_VERSION.'") as collectd_version,
		MAX(csp.id_config_project) as  id_config_project
	FROM config_server cs
		LEFT JOIN config_server_project csp 
			ON cs.id_config_server=csp.id_config_server 
		LEFT JOIN perm_project_group ppg 
			ON ppg.id_config_project=csp.id_config_project
		LEFT JOIN auth_group ag 
			ON ag.id_auth_group=ppg.id_auth_group
		LEFT JOIN auth_user_group aug 
			ON aug.id_auth_group=ag.id_auth_group
	WHERE aug.id_auth_user=:s_id_user
	AND cs.server_name=:f_host
	GROUP BY id_config_server, server_name
	ORDER BY server_name';

	$connSQL->bind('s_id_user',$s_id_user);
	$connSQL->bind('f_host',$f_host);

	$cur_server=$connSQL->row($lib);

if (isset($cur_server->id_config_server)) {
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
		aug.id_auth_user=:s_id_user
	AND ppg.id_config_project=:r_id_config_project
	ORDER BY plugin_order, plugin, plugin_instance, type, type_instance';

$connSQL=new DB();
$connSQL->bind('s_id_user',$s_id_user);
$connSQL->bind('r_id_config_project',$cur_server->id_config_project);
$pg_filters=$connSQL->query($lib);

if (isset($time_start) && isset($time_end)) {
	$zoom='onclick="Show_Popup($(this).attr(\'src\').split(\'?\')[1],\'\',\''.$time_start.'\',\''.$time_end.'\')"';
} else {
	$zoom='onclick="Show_Popup($(this).attr(\'src\').split(\'?\')[1],\''.$time_range.'\',\'\',\'\')"';
}
$dgraph=0;
if (is_dir($CONFIG['datadir']."/$cur_server->server_name/")) {
	$myregex='';
	foreach ($pg_filters as $filter) {
		if (empty($myregex)) {
			$myregex='#^((('.$CONFIG['datadir'].'/'.$cur_server->server_name.'/)('.$filter->plugin.')(?:\-('.$filter->plugin_instance.'))?/('.$filter->type.')(?:\-('.$filter->type_instance.'))?\.rrd)';
		} else {
			$myregex=$myregex.'|(('.$CONFIG['datadir'].'/'.$cur_server->server_name.'/)('.$filter->plugin.')(?:\-('.$filter->plugin_instance.'))?/('.$filter->type.')(?:\-('.$filter->type_instance.'))?\.rrd)';
		}
	}
	$myregex=$myregex.')#';

	$tplugins = preg_find($myregex, $CONFIG['datadir'].'/'.$cur_server->server_name, PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH|PREG_FIND_SORTBASENAME);
	if ($tplugins) $dgraph=1;
	$plugins = (sort_plugins($CONFIG['datadir'].'/'.$cur_server->server_name,$tplugins, $pg_filters));

	if ($plugins) $dgraph=1;

	$old_t='';
	$old_pi='';
	$old_subpg='';
	$myregex='#^('.$CONFIG['datadir'].'/'.$cur_server->server_name.'/)(\w+)(?:\-(.*))?/(\w+)(?:\-(.*))?\.rrd#';
	foreach ($plugins as $plugin) {
		preg_match($myregex, $plugin['content'], $matches);

		if (isset($matches[2])) {
			$p=$matches[2];
			if (!isset($$p)) $$p=false;
		} else { 
			continue;
			$p=null; 
		}
		if (isset($matches[3])) {
			$pi=$matches[3];
			$pc=null;
			if (substr_count($pi, '-') >= 1 && preg_match($CONFIG['plugin_pcategory'], $p)) {
				$tmp=explode('-',$pi);
				// Fix when PI is null after separating PC/PI for example a directory named "MyHost/GenericJMX-cassandra_activity_request-/"
				if (strlen($tmp[1])) {
					$pc=$tmp[0];
					$pi=implode('-', array_slice($tmp,1));
				}
			// Copy PI to PC if no PC but Plugin can have a PC
			} else if (preg_match($CONFIG['plugin_pcategory'], $p)) {
				$pc=$pi;
				$pi=null;
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
			} else if (preg_match($CONFIG['plugin_tcategory'], $p)) {
				$tc=$ti;
				$ti=null;
			}
		} else { 
			$tc=null; 
			$ti=null; 
		}


		if (!isset(${$p.$pc.$pi.$t.$tc.$ti}) ) {
			if ($$p!=true && $p!='aggregation') {
				$lvl_p=2;
				$lvl_pc=$lvl_p+1;
				$lvl_pi=$lvl_pc;
				$lvl_tc=null;
				echo "<h$lvl_p>".ucfirst($p)."</h$lvl_p>";
				$$p=true;
				$others=false;
			} else if ($p == 'aggregation') {
				$lvl_p=2;
				$lvl_pc=$lvl_p;
				$lvl_pi=$lvl_pc;
				$lvl_tc=null;
				$others=false;
			}
			// Displaying Plugin Category if there is a Plugin Category
			if (isset($pc) && empty($$pc)) {
				echo "<h$lvl_pc>".ucfirst(str_replace('_', ' ', $pc))."</h$lvl_pc>";
				$lvl_pi=$lvl_pc+1;
				$$pc=true;
				$others=false;
			}
			// Displaying Plugin Instance for some plugins
			if (preg_match($CONFIG['title_pinstance'],$p) && strlen($pi) && ${$pc.$pi}!=true) {
				${$pc.$pi}=true;
				echo "<h$lvl_pi>".ucfirst(str_replace('_', ' ',$pi))."</h$lvl_pi>";
			// Displaying Type for SNMP
			} else if ($p=='snmp' && ${$p.$t}!=true) {
				${$p.$t}=true;
				echo "<h$lvl_pi>".ucfirst(str_replace('_', ' ',$t))."</h$lvl_pi>";
            }

			${$p.$pc.$pi.$t.$tc.$ti}=true;


			// Verif regex OK
			if (isset($p) && isset($t)) {
				if (!preg_match('/^(df|interface|oracle|snmp)$/', $p) || 
				   (((preg_replace('/[^0-9\.]/','',$cur_server->collectd_version) >= 5)
				     && !preg_match('/^(oracle|snmp)$/', $p) && $t!='df'))
			    ) {
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
								echo '<img class="imggraph" '.$zoom.' title="'.CLICK_ZOOM.'" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&amp;p='.urlencode($p).'&amp;pc='.urlencode($pc).'&amp;pi='.urlencode($pi).'&amp;t='.urlencode($t).'&amp;tc='.urlencode($tc).'&amp;ti='.urlencode($ti).'&amp;s='.$time_range.'" />'."\n";
							} else {
								echo '<img class="imggraph" '.$zoom.' title="'.CLICK_ZOOM.'" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&amp;p='.urlencode($p).'&amp;pc='.urlencode($pc).'&amp;pi='.urlencode($pi).'&amp;t='.urlencode($t).'&amp;tc='.urlencode($tc).'&amp;ti='.urlencode($ti).'&amp;s='.$time_start.'&amp;e='.$time_end.'" />'."\n";
							}
						}
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
							echo '<img class="imggraph" '.$zoom.' title="'.CLICK_ZOOM.'" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&amp;p='.urlencode($p).'&amp;pc='.urlencode($pc).'&amp;pi='.urlencode($pi).'&amp;t='.urlencode($t).'&amp;tc='.urlencode($tc).'&amp;ti='.urlencode($ti).'&amp;s='.$time_range.'" />'."\n";
						} else {
							echo '<img class="imggraph" '.$zoom.' title="'.CLICK_ZOOM.'" alt="rrd" src="'.DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&amp;p='.urlencode($p).'&amp;pc='.urlencode($pc).'&amp;pi='.urlencode($pi).'&amp;t='.urlencode($t).'&amp;tc='.urlencode($tc).'&amp;ti='.urlencode($ti).'&amp;s='.$time_start.'&amp;e='.$time_end.'" />'."\n";
						}
					}
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

/* VMHOST LibVirt */
$vmlist = preg_find('#^'.$cur_server->server_name.':#', $CONFIG['datadir'].'/', PREG_FIND_DIRMATCH|PREG_FIND_SORTBASENAME);

//print_r($vmlist);

foreach ($vmlist as $vmdir) {

	$tmp=explode(':',$vmdir);
	$vm=$tmp[1];

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

				echo '<img class="imggraph" '.$zoom.' title="'.CLICK_ZOOM.'" alt="rrd" src='.DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).':'.urlencode($vm).'&amp;p='.urlencode($p).'&amp;pc='.urlencode($pc).'&amp;pi='.urlencode($pi).'&amp;t='.urlencode($t).'&amp;tc='.urlencode($tc).'&amp;ti='.urlencode($ti).'&amp;s='.$time_range.' />';
			}
		}
	}
}
if ($dgraph===0) {
  echo NO_GRAPH;
}
echo '</div>';
if (PLUGIN_BAR === true) {
   echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/plugin_anchor.js"></script>';
}
echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/CGP.js"></script>';
?>
