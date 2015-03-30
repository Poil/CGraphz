<?php
include './config/config.php';

$auth = new AUTH_USER();

if(isset($_GET['datadir']) && isset($_GET['path'])){
	if ($auth->verif_auth()) {
		if ($file = validateRRDPath($_GET['datadir'],$_GET['path'])) {  
			$tmp=trim(substr($file,strlen(realpath($_GET['datadir']))),'/');
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
}
