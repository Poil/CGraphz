<?php
include('../config/config.php');

$prod=true;
$file_reporting="./insertion_doublon_reporting.json";

$connSQL=new DB();
$all_server=$connSQL->query('SELECT * FROM config_server ORDER BY server_name');
$cpt_server=count($all_server);

/* Listing des serveurs présent dans le RRD DIR et pas déjà affectés */
$filelist=array_values(array_diff(scandir($CONFIG['datadir']), array('..', '.', 'lost+found')));

$lib='
CREATE TEMPORARY TABLE server_list (
	`server_name` varchar(45) NOT NULL default \'\'
)';
$connSQL->query($lib);


$find='0';
$lib= 'INSERT INTO server_list (server_name) VALUES (';  
$cpt_filelist=count($filelist);
for($i=0; $i<$cpt_filelist; $i++) {
	if (strpos($filelist[$i],':')==false && is_dir($CONFIG['datadir'].'/'.$filelist[$i])) {
		if($find=='1')  {
			$lib.=" ), (";
		}  
		$lib.= '\''.$filelist[$i].'\'';
		$find='1';
	}
}  
$lib.=' )';

if ($find=='1') {
	$connSQL->query($lib);


	$lib="SELECT server_name
		  FROM server_list 
		  GROUP BY server_name
		  HAVING COUNT(*) > 1";

	//////////////////////////////////////
	// Reporting des server en doublon
	if($prod){
		$serverDoublonBDD=$connSQL->query($lib);
		$serverDoublonDir=array();

		$serversDir=scandir($CONFIG['datadir']);

		$serverPresent=array();
		foreach($serversDir as $server){
			$server_name=strtoupper($server);
			if(!isset($serverPresent[$server_name])){
				$serverPresent[$server_name]=true;
			}else{
				$serverDoublonDir[]=$server_name;
			}
		}
	
		if(sizeof($serverDoublonBDD) > 0 || sizeof($serverDoublonDir) > 0){	
			$json = file_get_contents($file_reporting);
			if($json==NULL){
				$json="{}";	
			}
			$parsed_json=json_decode($json);
			
			$jsonServer="[";
			$serverMailBDD="";
			$serverMailDir="";
			$i=0;
			foreach($serverDoublonBDD as $server){
				if($i>0) $jsonServer.=",";
				$jsonServer.='"'.$server->server_name.'"';
				$serverMailBDD.=" - ".htmlentities($server->server_name)."<br>";
				$i++;
			}
			foreach($serverDoublonDir as $serverName){
                if($i>0) $jsonServer.=",";
                $jsonServer.='"'.$serverName.'"';
                $serverMailDir.=" - ".htmlentities($serverName)."<br>";
                $i++;
            }

			$jsonServer.="]";
	
			$parsed_json->server=json_decode($jsonServer);
	
			$serverMail="";

			if($serverMailBDD!=""){
				$serverMail.="Les serveurs en doublons en BDD sont :<br>".$serverMailBDD."<br><br>";
			}

			if($serverMailDir!=""){
                $serverMail.="Les serveurs en doublons dans les repertoires sont :<br>".$serverMailDir."<br><br>";
            }


			// Envoi de mail une fois par jours si il y a des doublons
			$toReport=false;
			if(isset($parsed_json->reporting)){
				$date_reporting=new DateTime($parsed_json->reporting);
				$date_reporting->add(new DateInterval("P1D"));
				$now=new DateTime();
	
				// Si le dernier reporting a etait fait il ya plus d'un jour alors on doit faire le reporting 
				if($date_reporting < $now ) $toReport=true;
			}else{
				$toReport=true;
			}
	
			if($toReport){
				$from="Reporting CGraphZ <si@fr.clara.net>";
				$to="FR-si@fr.clara.net";
				$passage_ligne = "\n";
				$header = "From: ".$from.$passage_ligne;
				$header .= "Reply-to: ".$from.$passage_ligne;
				$header .= "MIME-Version: 1.0".$passage_ligne;
				$header .= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
	
			    $sujet="[Reporting CGraphZ] Problème de doublon dans l'insertion de serveur CGraphZ";
	
				$messageHTML="
			    <html>
			        <body style='font-size : 12px; font-family : Verdana;'>
			            <p>
						Vous trouverez ci dessous la liste des serveurs en doublon dans CGraphZ. 
			            </p>
						<br>
						".$serverMail."
			        </body>
			    </html>";
				echo $messageHTML."\n";
			    mail($to,$sujet,$messageHTML,$header);
	
				$now=new DateTime();
				$parsed_json->reporting=$now->format("Y-m-d H:i:s");
			}
	
			$monfichier = fopen($file_reporting, 'a');
			ftruncate($monfichier,0);
			fputs($monfichier,json_encode($parsed_json));
			fclose($monfichier);
		// Sinon vide le fichier de reporting des doublons
		}else{
			$monfichier = fopen($file_reporting, 'a');
	        ftruncate($monfichier,0);
	        fputs($monfichier,"{}");
	        fclose($monfichier);
		}
	
	}




	/////////////////////////////////////
	// Insert
	$lib = 'INSERT INTO config_server (server_name, server_description) (
		  SELECT DISTINCT server_name, server_name as server_description
       		  FROM server_list
		  WHERE server_name NOT IN (
                	SELECT server_name FROM config_server
        	  ) 
		  GROUP BY server_name
		  HAVING COUNT(*) <= 1
		  ORDER BY server_name
		)';
	$connSQL->query($lib);
	
	/////////////////////////////////////
    // Link server not linked to all_servers project
	$lib = 'insert into config_server_project (id_config_server,id_config_project) (
		select id_config_server, 7 
		from config_server 
		where id_config_server not in (
			select id_config_server from config_server_project
		) order by id_config_server
	)';
	$connSQL->query($lib);
	
	/////////////////////////////////////
	// Purge removed server
	$lib='
		SELECT id_config_server
		FROM config_server 
		WHERE server_name NOT IN (
			SELECT server_name FROM server_list
		) ORDER BY server_name';
	
	$all_deleted_server=$connSQL->query($lib);
	
	foreach ($all_deleted_server as $cur_server) {
		$connSQL=new DB();
		echo 'Deleting '.$cur_server->id_config_server;
		$connSQL->bind('id_config_server',$cur_server->id_config_server);
		$lib='DELETE FROM config_role_server WHERE id_config_server=:id_config_server';
		$connSQL->query($lib);

		$connSQL->bind('id_config_server',$cur_server->id_config_server);
		$lib='DELETE FROM config_environment_server WHERE id_config_server=:id_config_server';
		$connSQL->query($lib);

		$connSQL->bind('id_config_server',$cur_server->id_config_server);
		$lib='DELETE FROM config_server_project WHERE id_config_server=:id_config_server';
		$connSQL->query($lib);

		$connSQL->bind('id_config_server',$cur_server->id_config_server);
		$lib='DELETE FROM config_server WHERE id_config_server=:id_config_server';
		$res = $connSQL->query($lib);

	}
}

?>
