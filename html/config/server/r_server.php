<?php
$connSQL=new DB();
$all_server=$connSQL->query('SELECT * FROM config_server ORDER BY server_name');
$cpt_server=count($all_server);

/* Listing des serveurs présent dans le RRD DIR et pas déjà affectés */
$filelist=scandir($CONFIG['datadir']);

$lib='
CREATE TEMPORARY TABLE server_list (
	`server_name` varchar(45) NOT NULL default \'\'
)';
$connSQL->query($lib);


$find='0';
$lib= 'INSERT INTO server_list (server_name) VALUES (';  
$cpt_filelist=count($filelist);
for($i=0; $i<$cpt_filelist; $i++) {
	if ($filelist[$i]!='lost+found' && $filelist[$i]!='..' && $filelist[$i]!='.' && strpos($filelist[$i],':')==false) {
		if($find=='1')  {
			$lib.=" ), (";
		}  
		$lib.= '\''.$filelist[$i].'\'';
		$find='1';
	}
}  
$lib.=' )';

if ($find=='1') $connSQL->query($lib);

$lib='
	SELECT * 
	FROM server_list 
	WHERE server_name NOT IN (
		SELECT server_name FROM config_server
	) ORDER BY server_name';

$all_rrdserver=$connSQL->query($lib);
$cpt_rrdserver=count($all_rrdserver);
?>
