<?php
	include('../../../config/config.php');
	include(DIR_FSROOT.'/modules/preg_find.php');	
	$tabGraphClient=array();	

	if(isset($_GET['idGuest'])){
		$f_host=filter_input(INPUT_GET,'f_host',FILTER_SANITIZE_STRING);
		$s_id_user=$_GET['idGuest'];

		$time_range=$_GET['timerange'];
		$time_start=$_GET['timestart'];
		$time_end=$_GET['timeend'];

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
						$$p=true;
						$others=false;
					} else if ($p == 'aggregation') {
						$lvl_pc=$lvl_p;
						$lvl_pi=$lvl_pc;
						$lvl_tc=null;
						$others=false;
					}
					// Displaying Plugin Category if there is a Plugin Category
					if (isset($pc) && empty($$pc)) {
						$lvl_pi=$lvl_pc+1;
						$$pc=true;
						$others=false;
					}
					// Displaying Plugin Instance for some plugins
					if (preg_match($CONFIG['title_pinstance'],$p) && strlen($pi) && $$pi!=true) {
						$$pi=true;
					}

					${$p.$pc.$pi.$t.$tc.$ti}=true;


					// Verif regex OK
					if (isset($p) && isset($t)) {
						if (!preg_match('/^(df|interface|oracle)$/', $p) || 
						   (((preg_replace('/[^0-9\.]/','',$cur_server->collectd_version) >= 5)
							 && (preg_replace('/[^a-zA-Z]/','',$cur_server->collectd_version) == 'Collectd') 
							 && $p!='oracle' && $t!='df'))
						   || (preg_replace('/[^a-zA-Z]/','',$cur_server->collectd_version) == 'SSC')
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

								} else {
									if ($time_range!='') {
										$tabGraphClient[]=DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&p='.urlencode($p).'&pc='.urlencode($pc).'&pi='.urlencode($pi).'&t='.urlencode($t).'&tc='.urlencode($tc).'&ti='.urlencode($ti).'&s='.$time_range;
									} else {
										$tabGraphClient[]=DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&p='.urlencode($p).'&pc='.urlencode($pc).'&pi='.urlencode($pi).'&t='.urlencode($t).'&tc='.urlencode($tc).'&ti='.urlencode($ti).'&s='.$time_start.'&e='.$time_end;
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
									$tabGraphClient[]=DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&p='.urlencode($p).'&pc='.urlencode($pc).'&pi='.urlencode($pi).'&t='.urlencode($t).'&tc='.urlencode($tc).'&ti='.urlencode($ti).'&s='.$time_range;
								} else {
									$tabGraphClient[]=DIR_WEBROOT.'/graph.php?h='.urlencode($cur_server->server_name).'&p='.urlencode($p).'&pc='.urlencode($pc).'&pi='.urlencode($pi).'&t='.urlencode($t).'&tc='.urlencode($tc).'&ti='.urlencode($ti).'&s='.$time_start.'&e='.$time_end;
								}
							}
						}
					} else if (DEBUG==true){
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

	foreach($tabGraphClient as $src){
		echo $src."|";
	}
?>
