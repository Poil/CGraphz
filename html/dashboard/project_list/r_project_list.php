<?php
$connSQL=new DB();

$lib='
SELECT cp.project_description, cp.id_config_project
FROM config_project cp
	LEFT JOIN perm_project_group ppg
		ON cp.id_config_project=ppg.id_config_project
	LEFT JOIN auth_group ag
		ON ppg.id_auth_group=ag.id_auth_group
	LEFT JOIN auth_user_group aug
		ON ag.id_auth_group=aug.id_auth_group
WHERE
	aug.id_auth_user="'.$_SESSION['S_ID_USER'].'"
GROUP BY id_config_project, project_description
ORDER BY project_description ';

$all_project=$connSQL->getResults($lib);

?>