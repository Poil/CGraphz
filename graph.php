<?php
//session_cache_limiter("private");
//ob_start();
include './config/config.php';
include DIR_FSROOT.'/modules/functions.inc.php';
	
session_name('CGRAPHZ');
session_start();
		
$connSQL=new DB();

$auth = new AUTH_USER();
if ($auth->verif_auth()) {

	$plugin = validate_get($_GET['p'], 'plugin');
	$host=validate_get($_GET['h'], 'host');
	if (strpos($host,':')!=FALSE) {
		$tmp=explode(':',$host);
		$host=$tmp[0];
	}
	$width = empty($_GET['x']) ? $CONFIG['width'] : $_GET['x'];
	$heigth = empty($_GET['y']) ? $CONFIG['heigth'] : $_GET['y'];
	$s=intval($_GET['s']);
	
	if (validate_get($_GET['h'], 'host') === NULL) {
	        error_log('CGRAPHZ ERROR: plugin contains unknown characters');
	        error_image();
	}
	
	if (!file_exists(DIR_FSROOT.'/plugin/'.$plugin.'.php')) {
	        error_log(sprintf('CGRAPHZ ERROR: plugin "%s" is not available', $plugin));
	        error_image();
	}
	
	$lib='
	SELECT cs.server_name
	FROM cgraphz.config_server cs
	  LEFT JOIN cgraphz.config_server_project csp 
        ON cs.id_config_server=csp.id_config_server
	  LEFT JOIN cgraphz.perm_project_group ppg 
        ON csp.id_config_project=ppg.id_config_project
	  LEFT JOIN cgraphz.auth_user_group aug 
        ON ppg.id_auth_group=aug.id_auth_group
	WHERE cs.server_name="'.$host.'" 
	  AND aug.id_auth_user='.intval($_SESSION['S_ID_USER']).'
	GROUP BY server_name
	ORDER BY server_name';
		
	$autorized=$connSQL->getRow($lib);
	
	if ($host==$autorized->server_name) {
		# load plugin
		include DIR_FSROOT.'/plugin/'.$plugin.'.php';
	} else {
		error_image();
	}
}
//ob_end_flush();
?>
