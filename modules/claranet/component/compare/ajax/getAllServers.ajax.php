<?php
	require('../../../../../config/config.php');

	require(DIR_FSROOT.'/modules/claranet/component/compare/Compare.class.php');
	$nb_find=0;
	if(isset($_GET['f_q'])){
		$f_q=$_GET['f_q'];

		$c=new Compare();
		if($f_q!=""){
			$servers=$c->getAllServers();

			foreach($servers as $serverName){
				if (strpos(strtoupper($serverName),strtoupper($f_q)) !== false) {
					$nb_find++;
					echo "<a onclick='completeAddHostInput($(this)); return false;' href=''>".$serverName."</a><br/>";
				}
			}
		}
	}
	if( $nb_find===0){
		echo "<span>Aucun serveur trouvé.</span>";
	}
?>
