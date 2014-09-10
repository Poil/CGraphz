<?php
	include('../../../config/config.php');

	include(DIR_FSROOT.'/modules/preg_find.php');

	// Permet la recuperation des graphs clients
	$_SESSION['S_ID_USER']=$_GET['idGuest'];

	// Mise en en variable du html généré pour le dashboard_light
	ob_start();
	include(DIR_FSROOT.'/html/dashboard/dashboard_light/d_dashboard_light.php');
	$html = ob_get_clean();

	$dom = new DOMDocument;
    $dom->loadHTML($html); 
 
    $xpath = new DOMXpath($dom);

	// Recherche de toutes les images
	$path = '//img';
    $imgs = $xpath->query($path);

	foreach($imgs as $img){
		echo $img->getAttribute("src")."|";		
	}
?>
