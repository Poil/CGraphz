<?php
//Si l'utilisateur est un "user" alors on verifie si il a le droit de voir ce serveur.
//Utilisé dans Modules/AUTH_USER, dans la fonction check_access_rigth. Bloque l'affichage de graphe si l'on est pas authorisé.	
//Testable à l'adresse graph.php?h=<nom du serveur>&p=load&pc=&pi=&t=load&tc=&ti=&s=7200
$serverOk=true;
if( isset($_SESSION['profile']) && $_SESSION['profile']=="user"){
	if(isset($_GET['f_host'])){
        $host=$_GET['f_host'];
    }
    if(isset($host)){
        $serverOk=false;
		//Récuperation des serveurs autorisé dans la variable de session "hierarchy"
        $hier_decode=json_decode($_SESSION["hierarchy"]);
		foreach($hier_decode as $projet){
			foreach($projet->hosts as $server){
				if(strtolower($server->name)==strtolower($host)){
					$serverOk=true;
                }
            }
            foreach($projet->wpm as $name){
				if(strtolower($name)==strtolower($host)){
                    $serverOk=true;
                }
            }
        }
    }
	if(isset($authorized) ){
		//Si le serveur n'est pas permis alors on n'authorise pas l'affichage du serveur.
		if(!$serverOk){
			$authorized=false;
		}
	}
}
?>
