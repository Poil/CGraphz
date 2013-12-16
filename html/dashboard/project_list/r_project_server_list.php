<?php
$connSQL=new DB();
if (isset($_GET['f_id_config_project'])) {
	$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_project=filter_input(INPUT_GET,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_role=filter_input(INPUT_GET,'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_environment=filter_input(INPUT_GET,'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
	
	if (isset($_GET['f_id_config_environment']) && $f_id_config_environment!==0) {
		$JOIN_ENV='LEFT OUTER JOIN config_environment_server ces
				ON cs.id_config_server=ces.id_config_server';
		$WHERE_ENV='AND ces.id_config_environment="'.$f_id_config_environment.'"';
	} else if (isset($_GET['f_id_config_environment']) &&  $f_id_config_environment===0) {
		$JOIN_ENV='LEFT OUTER JOIN config_environment_server ces
				ON cs.id_config_server=ces.id_config_server';
		$WHERE_ENV='AND ces.id_config_environment IS NULL';
	} else {
		$JOIN_ENV='';
		$WHERE_ENV='';
	}
	
	$connSQL->bind('f_id_config_project',$f_id_config_project);
	$connSQL->bind('s_id_user',$s_id_user);
	if (isset($_GET['f_id_config_role']) && $f_id_config_role!==0) {
		$lib='
		SELECT 
			cs.id_config_server, 
			cs.server_name 
		FROM config_server cs
			LEFT OUTER JOIN config_role_server crs
				ON cs.id_config_server=crs.id_config_server
			LEFT OUTER JOIN config_role cr
				ON crs.id_config_role=cr.id_config_role
			LEFT JOIN config_server_project csp 
				ON cs.id_config_server=csp.id_config_server
			'.$JOIN_ENV.' 
			LEFT JOIN perm_project_group ppg 
				ON ppg.id_config_project=csp.id_config_project
			LEFT JOIN auth_group ag 
				ON ag.id_auth_group=ppg.id_auth_group
			LEFT JOIN auth_user_group aug 
				ON aug.id_auth_group=ag.id_auth_group
		WHERE   csp.id_config_project=:f_id_config_project
			AND aug.id_auth_user=:s_id_user
			AND cr.id_config_role=:f_id_config_role
			'.$WHERE_ENV.'
		GROUP BY id_config_server, server_name
		ORDER BY server_name';
		$connSQL->bind('f_id_config_role',$f_id_config_role);
	
	} else if (isset($_GET['f_id_config_role']) &&  $f_id_config_role===0) {
		$lib='
		SELECT 
			cs.id_config_server, 
			cs.server_name 
		FROM config_server cs
			LEFT OUTER JOIN config_role_server crs
				ON cs.id_config_server=crs.id_config_server
			LEFT OUTER JOIN config_role cr
				ON crs.id_config_role=cr.id_config_role
			LEFT JOIN config_server_project csp 
				ON cs.id_config_server=csp.id_config_server 
			'.$JOIN_ENV.' 
			LEFT JOIN perm_project_group ppg 
				ON ppg.id_config_project=csp.id_config_project
			LEFT JOIN auth_group ag 
				ON ag.id_auth_group=ppg.id_auth_group
			LEFT JOIN auth_user_group aug 
				ON aug.id_auth_group=ag.id_auth_group
		WHERE   csp.id_config_project=:f_id_config_project
			AND aug.id_auth_user=:s_id_user
			AND crs.id_config_role IS NULL
			'.$WHERE_ENV.'
		GROUP BY id_config_server, server_name
		ORDER BY server_name';
	} else {
		$lib='
		SELECT 
			cs.id_config_server, 
			cs.server_name 
		FROM config_server cs
			LEFT JOIN config_server_project csp 
				ON cs.id_config_server=csp.id_config_server 
			'.$JOIN_ENV.' 
			LEFT JOIN perm_project_group ppg 
				ON ppg.id_config_project=csp.id_config_project
			LEFT JOIN auth_group ag 
				ON ag.id_auth_group=ppg.id_auth_group
			LEFT JOIN auth_user_group aug 
				ON aug.id_auth_group=ag.id_auth_group
		WHERE  csp.id_config_project=:f_id_config_project
			AND aug.id_auth_user=:s_id_user
			'.$WHERE_ENV.'
		GROUP BY id_config_server, server_name
		ORDER BY server_name';
	}
	
	
	$all_server=$connSQL->query($lib);
	$cpt_server=count($all_server);


	// Si plus de MAX_SRV Serveurs, on affiche des catégories
	if ($cpt_server>MAX_SRV || isset($_GET['f_id_config_role'])) {
		$f_id_config_project=intval(GET('f_id_config_project'));
		
		$lib='
		SELECT 
			cr.id_config_role, 
			CASE 
				WHEN cr.role_description IS NULL THEN "'.OTHERS.'"
			ELSE cr.role_description
			END AS role_description
		FROM config_server cs
			LEFT OUTER JOIN config_role_server crs
				ON cs.id_config_server=crs.id_config_server
			LEFT OUTER JOIN config_role cr
				ON crs.id_config_role=cr.id_config_role
			'.$JOIN_ENV.' 
			LEFT JOIN config_server_project csp 
				ON cs.id_config_server=csp.id_config_server 
			LEFT JOIN perm_project_group ppg 
				ON ppg.id_config_project=csp.id_config_project
			LEFT JOIN auth_group ag 
				ON ag.id_auth_group=ppg.id_auth_group
			LEFT JOIN auth_user_group aug 
				ON aug.id_auth_group=ag.id_auth_group
		WHERE  csp.id_config_project=:f_id_config_project
			AND aug.id_auth_user=:s_id_user
			'.$WHERE_ENV.'
		GROUP BY id_config_role, role_description
		ORDER BY role_description';
		
		$all_role=$connSQL->query($lib);
		$cpt_role=count($all_role);
	}	
	
	// Pour afficher les environnements si y en a
	$lib='
	SELECT 
		ce.id_config_environment, 
		CASE 
			WHEN ce.environment_description IS NULL THEN "'.OTHERS.'"
		ELSE ce.environment_description
		END AS environment_description
	FROM config_server cs
		LEFT OUTER JOIN config_environment_server ces
			ON cs.id_config_server=ces.id_config_server
		LEFT OUTER JOIN config_environment ce
			ON ces.id_config_environment=ce.id_config_environment
		LEFT JOIN config_server_project csp 
			ON cs.id_config_server=csp.id_config_server 
		LEFT JOIN perm_project_group ppg 
			ON ppg.id_config_project=csp.id_config_project
		LEFT JOIN auth_group ag 
			ON ag.id_auth_group=ppg.id_auth_group
		LEFT JOIN auth_user_group aug 
			ON aug.id_auth_group=ag.id_auth_group
	WHERE  csp.id_config_project=:f_id_config_project
		AND aug.id_auth_user=:s_id_user
	GROUP BY id_config_environment, environment_description
	ORDER BY environment_description';
	
	$all_environment=$connSQL->query($lib);
	$cpt_environment=count($all_environment);

}

?>
