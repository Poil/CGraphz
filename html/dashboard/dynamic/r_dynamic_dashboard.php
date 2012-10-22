<?php

$connSQL=new DB();
	
$lib='SELECT 
		cdd.* 
	FROM 
		config_dynamic_dashboard cdd
	LEFT JOIN config_dynamic_dashboard_group cddg
		ON cdd.id_config_dynamic_dashboard=cddg.id_config_dynamic_dashboard
	LEFT JOIN auth_user_group aug
		ON cddg.id_auth_group=aug.id_auth_group
	LEFT JOIN auth_user au
		ON aug.id_auth_user=au.id_auth_user
	WHERE aug.id_auth_user='.intval($_SESSION['S_ID_USER']).'
	GROUP BY cdd.title
	ORDER BY title';


$all_dd=$connSQL->getResults($lib);
$cpt_dd=count($all_dd);
?>