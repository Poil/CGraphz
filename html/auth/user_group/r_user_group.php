<?php
if (isset($_GET['f_id_auth_user'])) {
	$f_id_auth_user=intval($_GET['f_id_auth_user']);
		
	$connSQL=new DB();
	$lib='SELECT 
			aug.id_auth_user, 
			aug.id_auth_group, 
			aug.manager,
			au.`user`, 
			ag.`group`,
			ag.group_description
		FROM
			auth_user_group aug
				LEFT JOIN auth_user au
					ON aug.id_auth_user=au.id_auth_user
				LEFT JOIN auth_group ag
					ON aug.id_auth_group=ag.id_auth_group
		WHERE aug.id_auth_user="'.$f_id_auth_user.'"';

	$all_user_group=$connSQL->getResults($lib);
	$cpt_user_group=count($all_user_group);
	
	
	$lib='SELECT 
			* 
		FROM 
			auth_group
		WHERE 
			id_auth_group NOT IN (
				SELECT id_auth_group 
				FROM auth_user_group
				WHERE id_auth_user="'.$f_id_auth_user.'"
			)
		ORDER BY 
			`group`';
	
	$connSQL=new DB();
	$all_group=$connSQL->getResults($lib);
	$cpt_group=count($all_group);
}
?>