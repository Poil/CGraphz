<?php
include('../../../config/config.php');

$auth = new AUTH_USER();
if ($auth->verif_auth()) {

if ($_GET['f_q']) {
	$connSQL=new DB();
	$f_q=htmlentities($_GET['f_q']);
	
	$lib='
	SELECT 
		cs.id_config_server, 
		cs.server_name,
		MAX(csp.id_config_project) as  id_config_project
	FROM config_server cs
		LEFT JOIN config_server_project csp 
			ON cs.id_config_server=csp.id_config_server 
		LEFT JOIN perm_project_group ppg 
			ON ppg.id_config_project=csp.id_config_project
		LEFT JOIN auth_group ag 
			ON ag.id_auth_group=ppg.id_auth_group
		LEFT JOIN auth_user_group aug 
			ON aug.id_auth_group=ag.id_auth_group
	WHERE aug.id_auth_user='.intval($_SESSION['S_ID_USER']).'
	AND cs.server_name LIKE "%'.$f_q.'%"
	GROUP BY id_config_server, server_name
	ORDER BY server_name';
	
	$all_server=$connSQL->getResults($lib);
	$cpt_server=count($all_server);
	
	for ($i=0; $i<$cpt_server; $i++) {
		echo '<a href="#" 
			onclick="window.location.href=genUrl(\''.$all_server[$i]->id_config_server.'\',\''.$all_server[$i]->id_config_project.'\')">'.$all_server[$i]->server_name.'</a><br />';
	}
}
}
?>

