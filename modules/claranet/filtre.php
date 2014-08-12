<?php
	require "./../../config/config.php";
	//Permet la modification du filtre (vue client ou vue staff) en fonction de la variable $_GET["c"]
	if(isset($_GET["c"])){
		$_SESSION['filtre']=$_GET["c"];
	}
	//On redige vers la page d'avant.
	header('Location: ' . $_SERVER['HTTP_REFERER'] );

?>
