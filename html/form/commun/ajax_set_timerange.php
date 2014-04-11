<?php
include("../../../config/config.php");
session_name('CGRAPHZ');
session_start();

if (isset($_GET['time_start']) && isset($_GET['time_end'])) {
	if (strlen($_GET['time_start']) == strlen($_GET['time_end'])) {
		if (isset($_GET['time_start']) && is_numeric($_GET['time_start'])) {
			$_SESSION['time_start']=intval($_GET['time_start']);
			echo 'time_start is setted :'.$_SESSION['time_start']."\n";
		}
		
		if (isset($_GET['time_end']) && is_numeric($_GET['time_end'])) {
			$_SESSION['time_end']=intval($_GET['time_end']);
			echo 'time_end is setted :'.$_SESSION['time_end']."\n";
		}
		
		$_SESSION['time_range']='';
	} else {
		echo 'Erreur : '.strlen($_GET['time_start']).'!='.strlen($_GET['time_end']);
	}
}

if (isset($_GET['time_range']) && is_numeric($_GET['time_range'])) {
	$_SESSION['time_range']=intval($_GET['time_range']);
	$_SESSION['time_start']='';
	$_SESSION['time_end']='';
	
	echo 'time_range is setted :'.$_SESSION['time_range']."\n";
}
?>