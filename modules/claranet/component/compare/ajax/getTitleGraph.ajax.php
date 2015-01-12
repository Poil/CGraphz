<?php
	require('../../../../../config/config.php');

    require(DIR_FSROOT.'/modules/functions.inc.php');

	$getArray=array("h","p","pc","pi","t","tc","ti");

	foreach($getArray as $attr){
		if(!isset($_GET[$attr])){
			echo "Not Found!";
			die();
		}
	}

	chdir(DIR_FSROOT);

	ob_start();
	$title=gen_title($_GET['h'], $_GET['p'], $_GET['pc'], $_GET['pi'], $_GET['t'], $_GET['tc'], $_GET['ti']);
	ob_get_clean();

	echo $title;
	
?>
