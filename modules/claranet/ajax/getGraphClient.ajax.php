<?php
	include('../../../config/config.php');

	include(DIR_FSROOT.'/modules/preg_find.php');

	
	//Si l'utilisateur n'est pas un user alors on affiche la checkbox de vue client.
	$connSQL=new DB();
	
	$requete="SELECT id_auth_user FROM auth_user where user='staff';";
	$res=$connSQL->query($requete);
	
	$idStaff="";
	if(isset($res[0]) && isset($res[0]->id_auth_user)) $idStaff=$res[0]->id_auth_user;
	
	if(isset($_GET['idUser']) && $idStaff!="" && $_GET["idUser"]===$idStaff){
		$requete="SELECT id_auth_user FROM auth_user where user='guest';";
		$res=$connSQL->query($requete);
		
		$idGuest="";
		if(isset($res[0]) && isset($res[0]->id_auth_user)) $idGuest=$res[0]->id_auth_user;
		
		if($idGuest!=""){
			// Permet la recuperation des graphs clients
			$_SESSION['S_ID_USER']=$idGuest;
			
			// Mise en en variable du html généré pour le dashboard_light
			ob_start();
			include(DIR_FSROOT.'/html/dashboard/dashboard_light/d_dashboard_light.php');
			$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
					'.ob_get_clean().'
				</html>';
			
			$dom = new DOMDocument;
			// Pour eviter d'ajouter dans les log les problème de balise inconnue
			libxml_use_internal_errors(true);
			
			$dom->loadHTML($html);
			
			// Suppression des erreurs de balsie inconnue
			libxml_clear_errors();
			libxml_use_internal_errors(false);
			
			$xpath = new DOMXpath($dom);
			
			// Recherche de toutes les images
			$path = '//img';
			$imgs = $xpath->query($path);
			
			foreach($imgs as $img){
				echo $img->getAttribute("src")."|";
			}
		}
	}else{
		echo "all";
	}
?>
