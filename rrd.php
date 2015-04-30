<?php
include './config/config.php';

$auth = new AUTH_USER();

if ($auth->verif_auth()) {
	// Extract first datadir entry from path
	preg_match_all('/\//', $_SERVER['PATH_INFO'], $matches, PREG_OFFSET_CAPTURE);  
	$cur_datadir = substr($_SERVER['PATH_INFO'], 1, $matches[0][1][1]-1);

	// Remove datadir entry from path
	$_SERVER['PATH_INFO'] = substr($_SERVER['PATH_INFO'], $matches[0][1][1]);

	// Get datadir path from config via our datadir entry
	$datadir = $CONFIG['datadir'][$cur_datadir]['rrd_path'];
	if ($file = validateRRDPath($datadir, $_SERVER['PATH_INFO'])) {  
		$tmp=trim(substr($file,strlen(realpath($datadir))),'/');
		$host=substr($tmp,0,strpos($tmp,'/'));
		if (strpos($host,':')!=FALSE) {
			$tmp=explode(':',$host);
			$host=$tmp[0];
		}
	
		if ($auth->check_access_right($host)) {
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header("Expires: " .date(DATE_RFC822,strtotime($CONFIG['cache']." seconds")));
			if(ob_get_length()) ob_clean();
			flush();
			readfile($file);
		} else {
			header('HTTP/1.0 403 Forbidden');
		} 
	} else {
		header('HTTP/1.0 403 Forbidden');
	}
}

