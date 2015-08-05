<?php
	include('../../../config/config.php');
	
	include(DIR_FSROOT.'/modules/claranet/ClaratactClient.php');
	
	$claratactClient=new ClaratactClient();
	
	echo $claratactClient->getAllProject();
?>