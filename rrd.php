<?php
include './config/config.php';

session_name('CGRAPHZ');
session_start();

$auth = new AUTH_USER();

if ($auth->verif_auth()) {
	if ($file = validateRRDPath($CONFIG['datadir'], $_SERVER['PATH_INFO'])) {  
		$tmp=trim(substr($file,strlen(realpath($CONFIG['datadir']))),'/');
        $host=substr($tmp,0,strpos($tmp,'/'));
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
