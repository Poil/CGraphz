<?php
$connSQL=new DB();
$all_server=$connSQL->getResults('SELECT * FROM config_server ORDER BY server_name');
$cpt_server=count($all_server);

// Not needed, already done by module server.
/* Listing des serveurs présent dans le RRD DIR et pas déjà affectés */
/*
$filelist=scandir($CONFIG['datadir']);
$connSQL=new DB();

$lib='
CREATE TEMPORARY TABLE server_list (
	`server_name` varchar(45) NOT NULL default \'\'
)';
$connSQL->query($lib);


$find='0';
$lib= 'INSERT INTO server_list (`server_name`) VALUES (';  
for($i=0; $i<count($filelist); $i++) {
	if ($filelist[$i]!='lost+found' && $filelist[$i]!='..' && $filelist[$i]!='.' && strpos($filelist[$i],':')==false) {
		if($find=='1')  {
			$lib.=" ), (";
		}  
		$lib.= '\''.$filelist[$i].'\'';
		$find='1';
	}
}  
$lib.=' )';
if ($find=='1')
	$connSQL->query($lib);
*/

$lib='
	SELECT * 
	FROM config_server 
	WHERE server_name NOT IN (
		SELECT server_name FROM server_list
	) ORDER BY server_name';

$all_deleted_server=$connSQL->getResults($lib);
$cpt_deleted_server=count($all_deleted_server);
?>