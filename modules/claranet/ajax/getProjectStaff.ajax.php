<?php
	include('../../../config/config.php');
	
	include(DIR_FSROOT.'/modules/claranet/ClaratactClient.php');
	
	$host='';
	if(isset($_GET['host'])) $host=$_GET['host'];
	
	$claratactClient=new ClaratactClient();
	
	echo $claratactClient->getAllProject($host);
?>