<?php
//session_cache_limiter("private");
include './config/config.php';
	
session_name('CGRAPHZ');
session_start();

$auth = new AUTH_USER();
if ($auth->verif_auth()) {
	$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

	$plugin = validate_get(GET('p'), 'plugin');
	$host=validate_get(GET('h'), 'host');
	
	if (strpos($host,':')!=FALSE) {
		$tmp=explode(':',$host);
		$host=$tmp[0];
	}
	$width = empty($_GET['x']) ? $CONFIG['width'] : $_GET['x'];
	$height = empty($_GET['y']) ? $CONFIG['height'] : $_GET['y'];
	$s=intval($_GET['s']);
	if (($width * $height) <= MAX_IMG_SIZE) {	
		if (validate_get(GET('h'), 'host') === NULL) {
		        error_log('CGRAPHZ ERROR: plugin contains unknown characters');
		        error_image('[ERROR] plugin contains unknown characters');
		}
		
		if (!file_exists(DIR_FSROOT.'/plugin/'.$plugin.'.php')) {
		        error_log(sprintf('CGRAPHZ ERROR: plugin "%s" is not available', $plugin));
		        error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
		}
	
		$connSQL=new DB();
		$lib='
		SELECT 
			cs.server_name, 
			COALESCE(cs.collectd_version,"'.COLLECTD_DEFAULT_VERSION.'") as collectd_version
		FROM config_server cs
		  LEFT JOIN config_server_project csp 
	        ON cs.id_config_server=csp.id_config_server
		  LEFT JOIN perm_project_group ppg 
	        ON csp.id_config_project=ppg.id_config_project
		  LEFT JOIN auth_user_group aug 
	        ON ppg.id_auth_group=aug.id_auth_group
		WHERE (cs.server_name=:host)
		  AND (aug.id_auth_user=:s_id_user)
		GROUP BY server_name
		ORDER BY server_name';

		$connSQL->bind('host', $host);
		$connSQL->bind('s_id_user',$s_id_user);

		$authorized=$connSQL->row($lib);

		if ($host==$authorized->server_name) {
			# load plugin
			$CONFIG['version']=$authorized->collectd_version;
			include DIR_FSROOT.'/plugin/'.$plugin.'.php';
		} else {		
			error_image('[ERROR] Permission denied');
		}
	} else {
	        error_log('CGRAPHZ ERROR: image request is too big');
		error_image('[ERROR] Image request is too big');
	}
}

