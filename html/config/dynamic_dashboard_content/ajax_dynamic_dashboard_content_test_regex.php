<?php
include('../../../config/config.php');
include('../../../modules/preg_find.php');

$auth = new AUTH_USER();
if (!$auth->verif_auth()) {
	die();
}

if ($_POST['f_regex_srv']) {
	$f_regex_srv=mysql_escape_string(filter_input(INPUT_POST,'f_regex_srv',FILTER_SANITIZE_SPECIAL_CHARS));
	
	$connSQL=new DB();
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
		AND cs.server_name REGEXP "'.$f_regex_srv.'"
	GROUP BY id_config_server, server_name
	ORDER BY server_name';
	
	$all_server=$connSQL->getResults($lib);
	$cpt_server=count($all_server);
	
	$f_regex_p=filter_input(INPUT_POST,'f_regex_p',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_regex_pi=filter_input(INPUT_POST,'f_regex_pi',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_regex_t=filter_input(INPUT_POST,'f_regex_t',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_regex_ti=filter_input(INPUT_POST,'f_regex_ti',FILTER_SANITIZE_SPECIAL_CHARS);

	for ($i=0; $i<$cpt_server; $i++) {
		if (is_dir($CONFIG['datadir'].'/'.$all_server[$i]->server_name.'/')) {
			$myregex='#^('.$CONFIG['datadir'].'/'.$all_server[$i]->server_name.'/)('.$f_regex_p.')(?:\-('.$f_regex_pi.'))?/('.$f_regex_t.')(?:\-('.$f_regex_ti.'))?\.rrd#';

			$plugins = preg_find($myregex, $CONFIG['datadir'].'/'.$all_server[$i]->server_name, PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH|PREG_FIND_SORTBASENAME);
			foreach ($plugins as $plugin) {
				preg_match($myregex, $plugin, $matches);
				if (isset($matches[2])) {
					$str=$matches[2];
				}
				if (isset($matches[3]) && $matches[3]!='') {
					$str.='-'.$matches[3].'/';
				} else { 
					$str.='/'; 
				}
				if (isset($matches[4])) {
					$str.=$matches[4];
				}
				if (isset($matches[5]) && $matches[5]!='') {
					$str.='-'.$matches[5].'.rrd';
				} else { 
					$str.='.rrd'; 
				}
				$plugin_array[]=$str;
			}
			
		}
	}

	echo '<div>
	Serveurs trouvés<br />';
	foreach ($all_server as $server) {
		echo $server->server_name.', ';
	}
	echo '</div><br />
	<div>
	RRDs trouvés<br />';
	
	$plugin_array=array_unique($plugin_array,SORT_REGULAR);

	foreach ($plugin_array as $plugin) {
		echo $plugin.'<br />';
	}
	echo '</div>';
}
?>	