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
	if ($authorized=$auth->check_access_right($host)) {
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
			$CONFIG['version']=$authorized->collectd_version;
			include DIR_FSROOT.'/plugin/'.$plugin.'.php';
		} else {
		        error_log('CGRAPHZ ERROR: image request is too big');
			error_image('[ERROR] Image request is too big');
		}
	} else {		
		error_image('[ERROR] Permission denied');
	}
}
