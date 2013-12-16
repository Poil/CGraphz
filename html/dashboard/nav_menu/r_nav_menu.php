<?php
$connSQL=new DB();
$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

$lib='SELECT
		cp.id_config_project,
		cp.project_description,
		cs.id_config_server,
		cs.server_name,
		cr.id_config_role,
		COALESCE(cr.role_description, "'.OTHERS.'") as role_description
	FROM config_project cp 
	LEFT JOIN config_server_project csp 
		ON cp.id_config_project=csp.id_config_project 
	LEFT JOIN config_server cs 
		ON csp.id_config_server=cs.id_config_server 
	LEFT JOIN config_role_server crs 
		ON cs.id_config_server=crs.id_config_server 
	LEFT JOIN config_role cr 
		ON crs.id_config_role=cr.id_config_role
	LEFT JOIN perm_project_group ppg 
		ON ppg.id_config_project=csp.id_config_project
	LEFT JOIN auth_group ag 
		ON ag.id_auth_group=ppg.id_auth_group
	LEFT JOIN auth_user_group aug 
		ON aug.id_auth_group=ag.id_auth_group
	WHERE 
		aug.id_auth_user=:s_id_user
	ORDER BY project_description, role_description, server_name';

$connSQL->bind('s_id_user',$s_id_user);
$all_nav=$connSQL->query($lib);
$cpt_nav=count($all_nav);

