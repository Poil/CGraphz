<?php
$connSQL=new DB();

$lib='SELECT cdd.* 
	FROM config_dynamic_dashboard cdd
	LEFT JOIN config_dynamic_dashboard_group cddg
		ON cdd.id_config_dynamic_dashboard=cddg.id_config_dynamic_dashboard
	LEFT JOIN auth_user_group aug
		ON cddg.id_auth_group=aug.id_auth_group	 
	WHERE aug.id_auth_user='.intval($_SESSION['S_ID_USER']).'
	GROUP BY cdd.title
	ORDER BY cdd.title';

$all_dynamic_dashboard=$connSQL->getResults($lib);
$cpt_dynamic_dashboard=count($all_dynamic_dashboard);
?>